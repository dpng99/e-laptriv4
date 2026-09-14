<?php

namespace Database\Seeders;

use App\Models\DokumenKinerja;
use Illuminate\Database\Seeder;

class DokumenKinerjaSeeder extends Seeder
{
    public function run(): void
    {
        DokumenKinerja::query()->updateOrCreate(
            ['kode' => 'KEPJA-1184-2025'],
            [
                'jenis' => 'KEPJA',
                'nomor' => '1184 Tahun 2025',
                'nama' => 'Indikator Kinerja Utama Kejaksaan RI Tahun 2025–2029',
                'versi' => '1',
                'tahun_mulai' => 2025,
                'tahun_selesai' => 2029,
                'status' => 'BERLAKU',
                'file_path' => 'KEPJA 1184_Indikator Kinerja Utama IKU 2025-2029.pdf',
            ],
        );

        DokumenKinerja::query()->updateOrCreate(
            ['kode' => 'RENSTRA-KEJAKSAAN-2025-2029'],
            [
                'jenis' => 'RENSTRA',
                'nomor' => null,
                'nama' => 'Rencana Strategis Kejaksaan RI Tahun 2025–2029',
                'versi' => 'Final',
                'tahun_mulai' => 2025,
                'tahun_selesai' => 2029,
                'status' => 'BERLAKU',
                'file_path' => 'A.1.3. Renstra Kejaksaan 2025-2029-Final.pdf',
            ],
        );
    }
}
