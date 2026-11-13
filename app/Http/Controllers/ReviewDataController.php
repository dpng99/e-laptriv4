<?php

namespace App\Http\Controllers;

use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use App\Models\UnitKerja;
use App\Services\NodeVisibilityService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewDataController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'nullable|integer|between:2020,2099',
            'triwulan' => 'nullable|integer|between:1,4',
            'show_hidden' => 'nullable|boolean',
        ]);

        $tahun = (int) ($validated['tahun'] ?? date('Y'));
        $triwulan = (int) ($validated['triwulan'] ?? 1);
        $showHidden = filter_var($request->input('show_hidden', false), FILTER_VALIDATE_BOOLEAN);

        $nodes = KinerjaNode::whereIn('jenis_node', ['SP', 'IKP', 'SK', 'IKK'])
            ->with([
                'sp', 'ikp', 'sk', 'ikk', 'units', 'parents.sk',
                'children.pengukurans' => fn ($q) => $q->where('tahun', $tahun)->where('triwulan', $triwulan),
                'targets' => fn ($q) => $q->where('tahun', $tahun),
                'pengukurans' => fn ($q) => $q->where('tahun', $tahun)->where('triwulan', $triwulan),
            ])->get();

        $allData = $nodes->map(function ($node) use ($tahun, $triwulan) {
            $tipe = $node->jenis_node?->value ?? (string) $node->jenis_node;

            $kode = match ($tipe) {
                'SP' => $node->sp?->kode_sp ?: $node->kode,
                'IKP' => $node->ikp?->kode_ikp ?: $node->kode,
                'SK' => $node->sk?->kode_sk ?: $node->kode,
                'IKK' => $node->ikk?->kode_ikk ?: $node->kode,
                default => '-',
            } ?? '-';

            $nama = match ($tipe) {
                'SP' => $node->sp?->nama_sp ?: $node->nama,
                'IKP' => $node->ikp?->nama_ikp ?: $node->nama,
                'SK' => $node->sk?->nama_sk ?: $node->nama,
                'IKK' => $node->ikk?->nama_ikk ?: $node->nama,
                default => '-',
            } ?? '-';

            $unitName = $node->units?->pluck('nama')->join(', ') ?: '-';

            $parentSk = $tipe === 'IKK'
                ? $node->parents->first(fn ($p) => ($p->jenis_node?->value ?? (string) $p->jenis_node) === 'SK')
                : null;
            $parentSkActive = $parentSk ? (bool) $parentSk->is_active : true;
            $parentSkKode = $parentSk ? ($parentSk->sk?->kode_sk ?: $parentSk->kode) : null;
            $effectiveVisible = (bool) $node->is_active && ($tipe !== 'IKK' || $parentSkActive);

            $pengukuran = $node->pengukurans->first();
            $targetModel = app(\App\Services\TargetResolver::class)->choose($node->targets, $triwulan);
            $targetVal = ($pengukuran?->isFinal() || $pengukuran?->target_snapshot !== null)
                ? $pengukuran->target_snapshot
                : ($targetModel?->nilai_target !== null ? (float) $targetModel->nilai_target : null);

            $realisasi = $pengukuran?->realisasi !== null ? (float) $pengukuran->realisasi : null;
            $capaian = $pengukuran?->capaian !== null ? (float) $pengukuran->capaian : null;

            // For SP level, if no direct measurement, compute achievement from its IKP children
            if ($capaian === null && $tipe === 'SP') {
                $ikpChildren = $node->children->filter(fn ($c) => ($c->jenis_node?->value ?? $c->jenis_node) === 'IKP');
                $ikpCapaians = $ikpChildren->map(fn ($c) => $c->pengukurans->first()?->capaian)->filter(fn ($v) => $v !== null);
                if ($ikpCapaians->isNotEmpty()) {
                    $capaian = round((float) $ikpCapaians->avg(), 2);
                }
            }

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
                'hasil_kinerja' => $realisasi,
                'capaian_terhadap_target' => $capaianTerhadapTarget,
                'analisis_capaian' => $pengukuran?->analisis_capaian,
                'kendala' => $pengukuran?->kendala,
                'upaya' => $pengukuran?->upaya,
                'tahun' => $tahun,
                'triwulan' => $triwulan,
                'status' => $status,
                'is_active' => (bool) $node->is_active,
                'parent_sk_active' => $parentSkActive,
                'parent_sk_kode' => $parentSkKode,
                'effective_visible' => $effectiveVisible,
                'can_toggle_visibility' => in_array($tipe, ['SK', 'IKK'], true),
            ];
        })->sortBy('kode_indikator')->values();

        $visibleData = $showHidden
            ? $allData
            : $allData->where('effective_visible', true)->values();

        // Summary metrics for SP and IKP
        $spRows = $visibleData->where('tipe_indikator', 'SP');
        $ikpRows = $visibleData->where('tipe_indikator', 'IKP');

        $spFilled = $spRows->whereNotNull('capaian_terhadap_target');
        $ikpFilled = $ikpRows->whereNotNull('capaian_terhadap_target');

        $summary = [
            'totalSp' => $spRows->count(),
            'totalIkp' => $ikpRows->count(),
            'avgCapaianSp' => $spFilled->isNotEmpty() ? round($spFilled->avg('capaian_terhadap_target'), 2) : 0,
            'avgCapaianIkp' => $ikpFilled->isNotEmpty() ? round($ikpFilled->avg('capaian_terhadap_target'), 2) : 0,
        ];

        $visibilitySummary = app(NodeVisibilityService::class)->getVisibilitySummary();
        $units = UnitKerja::where('is_active', true)
            ->whereNotIn('kode', ['JAMBIN', 'SET-JAMBIN'])
            ->orderBy('id')
            ->get(['id', 'kode', 'nama']);

        return Inertia::render('ReviewData/Index', [
            'data' => $visibleData,
            'allData' => $allData,
            'summary' => $summary,
            'visibilitySummary' => $visibilitySummary,
            'units' => $units,
            'showHidden' => $showHidden,
            'currentTahun' => $tahun,
            'currentTriwulan' => $triwulan,
        ]);
    }

    public function show($id, Request $request)
    {
        $node = KinerjaNode::with(['sp', 'ikp', 'sk', 'ikk', 'units', 'formulas', 'referensi.dokumen'])->findOrFail($id);

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

        $activeFormula = $node->formulas->firstWhere('is_active', true) ?? $node->formulas->first();
        $tipeFormula = $activeFormula?->tipe_formula?->value ?? $activeFormula?->tipe_formula ?? $node->calculation_type ?? $node->formula_key ?? 'DIRECT_VALUE';

        $refDocs = $node->referensi->map(function ($ref) {
            $namaDoc = $ref->dokumen?->nama ?? 'Dokumen Kinerja';
            $hal = $ref->halaman ? " (Hal. {$ref->halaman})" : '';
            return $namaDoc . $hal;
        })->filter()->unique()->join('; ');

        $sumberData = $refDocs ?: ($node->referensi->first()?->catatan ?: 'Renstra Kejaksaan RI / Kepja 1184 Tahun 2025');

        $indikator = [
            'id' => $node->id,
            'kode_indikator' => $kode,
            'nama_kinerja' => $nama,
            'level' => $tipe,
            'unit_pengampu' => $node->units?->pluck('nama')->join(', ') ?: '-',
            'tipe_formula' => $tipeFormula,
            'sumber_data' => $sumberData,
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
                    'hasil_kinerja' => $realisasi,
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
