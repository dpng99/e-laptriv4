<?php

namespace App\Http\Controllers;

use App\Models\KinerjaNode;
use App\Models\UnitKerja;
use App\Services\TargetResolver;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'nullable|integer|between:2020,2099',
            'triwulan' => 'nullable|integer|between:1,4',
        ]);

        $tahun = (int) ($validated['tahun'] ?? date('Y'));
        $triwulan = (int) ($validated['triwulan'] ?? 1);
        $targetResolver = app(TargetResolver::class);

        // 1. Ambil 20 IKP untuk 4 KPI Cards & Modal Drilldown
        $ikpNodes = KinerjaNode::where('jenis_node', 'IKP')
            ->with([
                'ikp',
                'units',
                'targets' => fn ($q) => $q->where('tahun', $tahun),
                'pengukurans' => fn ($q) => $q->where('tahun', $tahun)->where('triwulan', $triwulan),
            ])
            ->orderBy('kode')
            ->get();

        $ikpList = $ikpNodes->map(function ($node) use ($triwulan, $targetResolver) {
            $pengukuran = $node->pengukurans->first();
            $targetModel = $targetResolver->choose($node->targets, $triwulan);
            $targetVal = ($pengukuran?->isFinal() || $pengukuran?->target_snapshot !== null)
                ? $pengukuran->target_snapshot
                : ($targetModel?->nilai_target !== null ? (float) $targetModel->nilai_target : null);

            $targetDisplay = $targetVal !== null ? $targetVal : ($targetModel?->nilai_teks_sumber ?: '-');
            $realisasi = $pengukuran?->realisasi !== null ? (float) $pengukuran->realisasi : null;
            $capaian = $pengukuran?->capaian !== null ? (float) $pengukuran->capaian : null;

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
                'kode' => $node->ikp?->kode_ikp ?: $node->kode,
                'nama' => $node->ikp?->nama_ikp ?: $node->nama,
                'satuan' => $node->satuan ?: ($node->ikp?->satuan ?: ''),
                'unit' => $node->units->pluck('nama')->join(', ') ?: '-',
                'unit_kode' => $node->units->pluck('kode')->join(', ') ?: '-',
                'target' => $targetDisplay,
                'realisasi' => $realisasi,
                'capaian' => $capaian,
                'status' => $status,
                'kendala' => $pengukuran?->kendala,
                'upaya' => $pengukuran?->upaya,
            ];
        });

        $totalTercapai = $ikpList->where('status', 'Tercapai')->count();
        $totalBelumTercapai = $ikpList->whereIn('status', ['Belum Tercapai', 'Tidak Tercapai'])->count();
        $totalBelumDiisi = $ikpList->where('status', 'Belum Diisi')->count();

        // 2. Monitoring Pengisian Biro & Pusat
        $bureauUnits = UnitKerja::where('is_active', true)
            ->whereNotIn('kode', ['SET-JAMBIN'])
            ->orderBy('id')
            ->get();

        $unitMonitoring = [];
        foreach ($bureauUnits as $unit) {
            $assignedNodes = $unit->nodes()
                ->whereIn('jenis_node', ['IKK', 'IKP'])
                ->with([
                    'ikk', 'ikp',
                    'targets' => fn ($q) => $q->where('tahun', $tahun),
                    'pengukurans' => fn ($q) => $q->where('tahun', $tahun)->where('triwulan', $triwulan),
                ])
                ->orderBy('kode')
                ->get();

            $totalIndikator = $assignedNodes->count();
            $terisiCount = 0;
            $sumCapaian = 0;
            $rincian = [];

            foreach ($assignedNodes as $node) {
                $tipe = $node->jenis_node?->value ?? (string) $node->jenis_node;
                $kode = $tipe === 'IKP' ? ($node->ikp?->kode_ikp ?: $node->kode) : ($node->ikk?->kode_ikk ?: $node->kode);
                $nama = $tipe === 'IKP' ? ($node->ikp?->nama_ikp ?: $node->nama) : ($node->ikk?->nama_ikk ?: $node->nama);

                $pengukuran = $node->pengukurans->firstWhere('unit_kerja_id', $unit->id) ?? $node->pengukurans->first();
                $targetModel = $targetResolver->choose($node->targets, $triwulan);
                $targetVal = ($pengukuran?->isFinal() || $pengukuran?->target_snapshot !== null)
                    ? $pengukuran->target_snapshot
                    : ($targetModel?->nilai_target !== null ? (float) $targetModel->nilai_target : null);
                $targetDisplay = $targetVal !== null ? $targetVal : ($targetModel?->nilai_teks_sumber ?: '-');

                $realisasi = $pengukuran?->realisasi !== null ? (float) $pengukuran->realisasi : null;
                $capaian = $pengukuran?->capaian !== null ? (float) $pengukuran->capaian : null;

                $isTerisi = ($realisasi !== null || $capaian !== null);
                if ($isTerisi) {
                    $terisiCount++;
                    if ($capaian !== null) {
                        $sumCapaian += $capaian;
                    }
                }

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

                $rincian[] = [
                    'id' => $node->id,
                    'kode' => $kode,
                    'nama' => $nama,
                    'tipe' => $tipe,
                    'satuan' => $node->satuan ?: ($node->ikk?->satuan ?: ''),
                    'target' => $targetDisplay,
                    'realisasi' => $realisasi,
                    'capaian' => $capaian,
                    'is_terisi' => $isTerisi,
                    'status' => $status,
                    'kendala' => $pengukuran?->kendala,
                    'upaya' => $pengukuran?->upaya,
                ];
            }

            $persentaseTerisi = $totalIndikator > 0 ? round(($terisiCount / $totalIndikator) * 100, 1) : 0;
            $rataCapaian = $terisiCount > 0 ? round($sumCapaian / $terisiCount, 2) : 0;

            $statusPengisian = 'Belum Mengisi';
            if ($totalIndikator > 0 && $terisiCount === $totalIndikator) {
                $statusPengisian = 'Lengkap';
            } elseif ($terisiCount > 0) {
                $statusPengisian = 'Sebagian Terisi';
            }

            $unitMonitoring[] = [
                'unit_id' => $unit->id,
                'unit_kode' => $unit->kode,
                'unit_nama' => $unit->nama,
                'total_indikator' => $totalIndikator,
                'terisi_count' => $terisiCount,
                'belum_diisi_count' => $totalIndikator - $terisiCount,
                'persentase_terisi' => $persentaseTerisi,
                'rata_capaian' => $rataCapaian,
                'status_pengisian' => $statusPengisian,
                'rincian' => $rincian,
            ];
        }

        // 3. Seluruh Node (SP, IKP, SK, IKK) untuk DataGrid komprehensif di bawah
        $allNodes = KinerjaNode::whereIn('jenis_node', ['SP', 'IKP', 'SK', 'IKK'])
            ->with([
                'sp', 'ikp', 'sk', 'ikk', 'units',
                'targets' => fn ($q) => $q->where('tahun', $tahun),
                'pengukurans' => fn ($q) => $q->where('tahun', $tahun)->where('triwulan', $triwulan),
            ])
            ->get();

        $statusList = $allNodes->map(function ($node) use ($triwulan, $targetResolver) {
            $tipe = $node->jenis_node?->value ?? (string) $node->jenis_node;
            $kode = match ($tipe) {
                'SP' => $node->sp?->kode_sp ?: $node->kode,
                'IKP' => $node->ikp?->kode_ikp ?: $node->kode,
                'SK' => $node->sk?->kode_sk ?: $node->kode,
                'IKK' => $node->ikk?->kode_ikk ?: $node->kode,
                default => $node->kode ?: '-',
            };
            $nama = match ($tipe) {
                'SP' => $node->sp?->nama_sp ?: $node->nama,
                'IKP' => $node->ikp?->nama_ikp ?: $node->nama,
                'SK' => $node->sk?->nama_sk ?: $node->nama,
                'IKK' => $node->ikk?->nama_ikk ?: $node->nama,
                default => $node->nama ?: '-',
            };

            $pengukuran = $node->pengukurans->first();
            $targetModel = $targetResolver->choose($node->targets, $triwulan);
            $targetVal = ($pengukuran?->isFinal() || $pengukuran?->target_snapshot !== null)
                ? $pengukuran->target_snapshot
                : ($targetModel?->nilai_target !== null ? (float) $targetModel->nilai_target : null);
            $targetDisplay = $targetVal !== null ? $targetVal : ($targetModel?->nilai_teks_sumber ?: '-');

            $realisasi = $pengukuran?->realisasi !== null ? (float) $pengukuran->realisasi : null;
            $capaian = $pengukuran?->capaian !== null ? (float) $pengukuran->capaian : null;

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
                'kode' => $kode,
                'nama' => $nama,
                'tipe' => $tipe,
                'unit' => $node->units->pluck('nama')->join(', ') ?: '-',
                'target' => $targetDisplay,
                'hasil_kinerja' => $realisasi,
                'capaian_terhadap_target' => $capaian,
                'status' => $status,
            ];
        })->sortBy('kode')->values();

        return Inertia::render('Admin/Dashboard', [
            'currentTahun' => $tahun,
            'currentTriwulan' => $triwulan,
            'statusList' => $statusList,
            'ikpList' => $ikpList->values(),
            'unitMonitoring' => $unitMonitoring,
            'stats' => [
                'total_indikator' => $ikpList->count(),
                'tercapai' => $totalTercapai,
                'belum_tercapai' => $totalBelumTercapai,
                'belum_diisi' => $totalBelumDiisi,
            ],
        ]);
    }
}
