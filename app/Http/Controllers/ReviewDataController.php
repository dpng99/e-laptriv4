<?php

namespace App\Http\Controllers;

use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewDataController extends Controller
{
    public function index(Request $request)
    {
        $tahun = (int) $request->input('tahun', date('Y'));
        $triwulan = (int) $request->input('triwulan', 1);

        $nodes = KinerjaNode::with([
            'sp', 'ikp', 'sk', 'ikk', 'units',
            'targets' => fn ($q) => $q->where('tahun', $tahun),
            'pengukurans' => fn ($q) => $q->where('tahun', $tahun)->where('triwulan', $triwulan),
        ])->get();

        $data = $nodes->map(function ($node) use ($tahun, $triwulan) {
            $tipe = $node->jenis_node?->value ?? (string) $node->jenis_node;

            $kode = match ($tipe) {
                'SP' => $node->sp?->kode_sp,
                'IKP' => $node->ikp?->kode_ikp,
                'SK' => $node->sk?->kode_sk,
                'IKK' => $node->ikk?->kode_ikk,
                default => '-',
            } ?? '-';

            $nama = match ($tipe) {
                'SP' => $node->sp?->nama_sp,
                'IKP' => $node->ikp?->nama_ikp,
                'SK' => $node->sk?->nama_sk,
                'IKK' => $node->ikk?->nama_ikk,
                default => '-',
            } ?? '-';

            $unitName = $node->units?->pluck('nama')->join(', ') ?: '-';

            $pengukuran = $node->pengukurans->first();
            $targetModel = app(\App\Services\TargetResolver::class)->choose($node->targets, $triwulan);
            $targetVal = ($pengukuran?->isFinal() || $pengukuran?->target_snapshot !== null)
                ? $pengukuran->target_snapshot
                : ($targetModel?->nilai_target !== null ? (float) $targetModel->nilai_target : null);

            $realisasi = $pengukuran?->realisasi !== null ? (float) $pengukuran->realisasi : null;
            $capaian = $pengukuran?->capaian !== null ? (float) $pengukuran->capaian : null;
            $capaianTerhadapTarget = $capaian;

            // Status Ketercapaian canonical SAKIP
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
            } elseif ($triwulan < 4) {
                $status = 'Belum Tercapai';
            } else {
                $status = 'Tidak Tercapai';
            }

            return [
                'id' => $node->id,
                'kode_indikator' => $kode,
                'tipe_indikator' => $tipe,
                'nama_kinerja' => $nama,
                'unit_pengampu' => $unitName,
                'target' => $targetVal,
                'realisasi' => $realisasi,
                'capaian_persen' => $capaian,
                'capaian_terhadap_target' => $capaianTerhadapTarget,
                'analisis_capaian' => $pengukuran?->analisis_capaian,
                'kendala' => $pengukuran?->kendala,
                'upaya' => $pengukuran?->upaya,
                'tahun' => $tahun,
                'triwulan' => $triwulan,
                'status' => $status,
            ];
        })->sortBy('kode_indikator')->values();

        // Summary metrics for SP and IKP
        $spRows = $data->where('tipe_indikator', 'SP');
        $ikpRows = $data->where('tipe_indikator', 'IKP');

        $spFilled = $spRows->whereNotNull('capaian_persen');
        $ikpFilled = $ikpRows->whereNotNull('capaian_persen');

        $summary = [
            'totalSp' => $spRows->count(),
            'totalIkp' => $ikpRows->count(),
            'avgCapaianSp' => $spFilled->isNotEmpty() ? round($spFilled->avg('capaian_persen'), 2) : 0,
            'avgCapaianIkp' => $ikpFilled->isNotEmpty() ? round($ikpFilled->avg('capaian_persen'), 2) : 0,
        ];

        return Inertia::render('ReviewData/Index', [
            'data' => $data,
            'summary' => $summary,
            'currentTahun' => $tahun,
            'currentTriwulan' => $triwulan,
        ]);
    }

    public function show($id, Request $request)
    {
        $node = KinerjaNode::with(['sp', 'ikp', 'sk', 'ikk', 'units'])->findOrFail($id);

        $tipe = $node->jenis_node?->value ?? (string) $node->jenis_node;
        $kode = match ($tipe) {
            'SP' => $node->sp?->kode_sp,
            'IKP' => $node->ikp?->kode_ikp,
            'SK' => $node->sk?->kode_sk,
            'IKK' => $node->ikk?->kode_ikk,
            default => '-',
        } ?? '-';

        $nama = match ($tipe) {
            'SP' => $node->sp?->nama_sp,
            'IKP' => $node->ikp?->nama_ikp,
            'SK' => $node->sk?->nama_sk,
            'IKK' => $node->ikk?->nama_ikk,
            default => '-',
        } ?? '-';

        $indikator = [
            'id' => $node->id,
            'kode_indikator' => $kode,
            'nama_kinerja' => $nama,
            'level' => $tipe,
            'unit_pengampu' => $node->units?->pluck('nama')->join(', ') ?: '-',
            'tipe_formula' => 'AGGREGATE / DIRECT',
            'sumber_data' => '-',
        ];

        $pengukurans = Pengukuran::where('node_id', $node->id)
            ->with(['target'])
            ->orderBy('tahun')
            ->orderBy('triwulan')
            ->get()
            ->map(function ($p) {
                $targetVal = ($p->isFinal() || $p->target_snapshot !== null)
                    ? $p->target_snapshot
                    : ($p->target?->nilai_target !== null ? (float) $p->target->nilai_target : null);
                $realisasi = $p->realisasi !== null ? (float) $p->realisasi : null;
                $capaian = $p->capaian !== null ? (float) $p->capaian : null;
                $capaianVsTarget = $capaian;

                return [
                    'id' => $p->id,
                    'tahun' => $p->tahun,
                    'triwulan' => $p->triwulan,
                    'target' => $targetVal,
                    'realisasi_aktual' => $realisasi,
                    'capaian_persen' => $capaian,
                    'capaian_terhadap_target' => $capaianVsTarget,
                    'status' => $p->status_capaian ?? ($capaian >= 100 ? 'TERCAPAI' : ($p->triwulan < 4 ? 'BELUM_TERCAPAI' : 'TIDAK_TERCAPAI')),
                    'analisis_capaian' => $p->analisis_capaian,
                    'kendala' => $p->kendala,
                    'upaya' => $p->upaya,
                ];
            });

        return Inertia::render('ReviewData/Show', [
            'indikator' => $indikator,
            'pengukurans' => $pengukurans,
        ]);
    }
}
