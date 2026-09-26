<?php

namespace App\Http\Controllers;

use App\Models\Pengukuran;
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

        // Ambil pengukuran untuk seluruh tingkatan kinerja
        $pengukurans = Pengukuran::with(['node.sp', 'node.ikp', 'node.sk', 'node.ikk', 'unit'])
            ->whereHas('node', function ($query) {
                $query->whereIn('jenis_node', ['SP', 'IKP', 'SK', 'IKK']);
            })
            ->where('tahun', $tahun)
            ->where('triwulan', $triwulan)
            ->get();

        $statusList = $pengukurans->map(function ($pengukuran) use ($triwulan) {
            $node = $pengukuran->node;
            $tipe = $node?->jenis_node?->value ?? (string) $node?->jenis_node ?? '-';
            
            $kode = match ($tipe) {
                'SP' => $node?->sp?->kode_sp,
                'IKP' => $node?->ikp?->kode_ikp,
                'SK' => $node?->sk?->kode_sk,
                'IKK' => $node?->ikk?->kode_ikk,
                default => '-',
            };

            $nama = match ($tipe) {
                'SP' => $node?->sp?->nama_sp,
                'IKP' => $node?->ikp?->nama_ikp,
                'SK' => $node?->sk?->nama_sk,
                'IKK' => $node?->ikk?->nama_ikk,
                default => '-',
            };

            $capaian = $pengukuran->capaian !== null ? (float) $pengukuran->capaian : null;

            if ($pengukuran->status_capaian !== null) {
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
                'id' => $pengukuran->id,
                'kode' => $kode,
                'nama' => $nama,
                'tipe' => $tipe,
                'unit' => $pengukuran->unit?->nama ?? '-',
                'hasil_kinerja' => $pengukuran->realisasi,
                'capaian_terhadap_target' => (float) ($capaian ?? 0),
                'status' => $status,
            ];
        });

        // Hitung statistik
        $totalTercapai = $statusList->where('status', 'Tercapai')->count();
        $totalBelumTercapai = $statusList->whereIn('status', ['Belum Tercapai', 'Tidak Tercapai'])->count();
        $totalBelumDiisi = $statusList->where('status', 'Belum Diisi')->count();

        return Inertia::render('Admin/Dashboard', [
            'currentTahun' => $tahun,
            'currentTriwulan' => $triwulan,
            'statusList' => $statusList->values(),
            'stats' => [
                'total_indikator' => $statusList->count(),
                'tercapai' => $totalTercapai,
                'belum_tercapai' => $totalBelumTercapai,
                'belum_diisi' => $totalBelumDiisi,
            ]
        ]);
    }
}
