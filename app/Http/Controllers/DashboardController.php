<?php

namespace App\Http\Controllers;

use App\Models\Ikk;
use App\Models\Pengukuran;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $unit = $request->user()->assignedUnit();
        abort_if($unit === null, 403, 'Bidang akun belum terhubung dengan unit kerja.');

        $validated = $request->validate([
            'tahun' => 'nullable|integer|between:2020,2099',
            'triwulan' => 'nullable|integer|between:1,4',
        ]);

        $tahun = (int) ($validated['tahun'] ?? date('Y'));
        $triwulan = (int) ($validated['triwulan'] ?? 1);

        $ikks = Ikk::query()
            ->whereHas('node.units', fn ($query) => $query->whereKey($unit->id))
            ->with([
                'node.parents.sk',
                'node.parents.parents.ikp',
                'node.parents.parents.parents.sp',
            ])
            ->orderBy('kode_ikk')
            ->get();

        $ikkNodeIds = $ikks->pluck('node_id');
        $pengukurans = Pengukuran::query()
            ->whereIn('node_id', $ikkNodeIds)
            ->where('unit_kerja_id', $unit->id)
            ->where('tahun', $tahun)
            ->where('triwulan', $triwulan)
            ->get()
            ->keyBy('node_id');

        $targets = app(\App\Services\TargetResolver::class)->resolveMany($ikkNodeIds, $tahun, $triwulan);

        $spNodeIds = collect();

        foreach ($ikks as $ikk) {
            foreach ($ikk->node?->parents ?? [] as $skNode) {
                foreach ($skNode->parents ?? [] as $ikpNode) {
                    foreach ($ikpNode->parents ?? [] as $spNode) {
                        if ($spNode->sp !== null) {
                            $spNodeIds->push($spNode->id);
                        }
                    }
                }
            }
        }

        $filledMeasurements = $pengukurans->filter(fn (Pengukuran $item) => $item->capaian !== null);

        $skGroups = [];
        foreach ($ikks as $ikk) {
            $skNode = $ikk->node?->parents?->firstWhere('jenis_node', \App\Enums\NodeType::SK);
            $skKode = $skNode?->kode ?: 'SK';
            $skNama = $skNode?->nama ?: ($skNode?->sk?->nama_sk ?: 'Sasaran Kegiatan');
            $pengukuran = $pengukurans->get($ikk->node_id);
            $capaian = $pengukuran?->capaian !== null ? (float) $pengukuran->capaian : null;

            if (!isset($skGroups[$skKode])) {
                $skGroups[$skKode] = [
                    'sk_kode' => $skKode,
                    'sk_nama' => $skNama,
                    'total' => 0,
                    'terisi' => 0,
                    'sum_capaian' => 0,
                ];
            }
            $skGroups[$skKode]['total']++;
            if ($capaian !== null) {
                $skGroups[$skKode]['terisi']++;
                $skGroups[$skKode]['sum_capaian'] += $capaian;
            }
        }

        $skPerformance = collect($skGroups)->map(function ($g) {
            return [
                'sk_kode' => $g['sk_kode'],
                'sk_nama' => $g['sk_nama'],
                'total' => $g['total'],
                'terisi' => $g['terisi'],
                'rata_capaian' => $g['terisi'] > 0 ? round($g['sum_capaian'] / $g['terisi'], 2) : 0,
            ];
        })->values();

        $statusList = $ikks->map(function (Ikk $ikk) use ($pengukurans, $targets, $triwulan): array {
            $pengukuran = $pengukurans->get($ikk->node_id);
            $target = $targets->get($ikk->node_id);
            $capaian = $pengukuran?->capaian !== null ? (float) $pengukuran->capaian : null;
            $realisasi = $pengukuran?->realisasi !== null ? (float) $pengukuran->realisasi : null;
            $nilaiTarget = ($pengukuran?->isFinal() || $pengukuran?->target_snapshot !== null)
                ? ($pengukuran->target_snapshot ?? '-')
                : ($target?->nilai_target !== null ? (float) $target->nilai_target : ($target?->nilai_teks_sumber ?? '-'));

            $skNode = $ikk->node?->parents?->firstWhere('jenis_node', \App\Enums\NodeType::SK);

            if ($pengukuran?->status_capaian !== null) {
                $status = match ($pengukuran->status_capaian) {
                    'TERCAPAI' => 'Tercapai',
                    'BELUM_TERCAPAI' => 'Belum Tercapai',
                    'TIDAK_TERCAPAI' => 'Tidak Tercapai',
                    'BELUM_DIINPUT' => 'Belum Diisi',
                    default => $pengukuran->status_capaian,
                };
            } elseif ($capaian === null) {
                $status = 'Belum Diisi';
            } elseif ($capaian >= 100) {
                $status = 'Tercapai';
            } elseif ($triwulan === 4) {
                $status = 'Tidak Tercapai';
            } else {
                $status = 'Belum Tercapai';
            }

            return [
                'kode' => $ikk->kode_ikk,
                'nama' => $ikk->nama_ikk,
                'satuan' => $ikk->satuan ?: ($ikk->node?->satuan ?: ''),
                'target' => $nilaiTarget,
                'realisasi' => $realisasi,
                'capaian' => $capaian,
                'status' => $status,
                'sk_kode' => $skNode?->kode ?: 'SK',
                'sk_nama' => $skNode?->nama ?: ($skNode?->sk?->nama_sk ?: ''),
            ];
        });

        $stats = [
            'total' => $ikks->count(),
            'terisi' => $filledMeasurements->count(),
            'tercapai' => $statusList->where('status', 'Tercapai')->count(),
            'belum_tercapai' => $statusList->whereIn('status', ['Belum Tercapai', 'Tidak Tercapai'])->count(),
            'belum_diisi' => $statusList->where('status', 'Belum Diisi')->count(),
        ];

        return Inertia::render('Dashboard', [
            'unitName' => $unit->nama,
            'totalSp' => $spNodeIds->unique()->count(),
            'totalIkk' => $ikks->count(),
            'ikkTerisi' => $filledMeasurements->count(),
            'rataCapaian' => round((float) ($filledMeasurements->avg('capaian') ?? 0), 2),
            'currentTahun' => $tahun,
            'currentTriwulan' => $triwulan,
            'statusList' => $statusList,
            'skPerformance' => $skPerformance,
            'stats' => $stats,
        ]);
    }
}
