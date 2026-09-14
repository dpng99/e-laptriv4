<?php

namespace Database\Seeders;

use App\Models\UnitKerja;
use Illuminate\Database\Seeder;

class UnitKerjaSeeder extends Seeder
{
    public function run(): void
    {
        $jambin = UnitKerja::query()->updateOrCreate(
            ['kode' => 'JAMBIN'],
            ['nama' => 'Jaksa Agung Muda Bidang Pembinaan', 'parent_id' => null, 'is_active' => true],
        );

        $units = [
            'SET-JAMBIN' => 'Sekretariat JAMBIN',
            'RO-REN' => 'Biro Perencanaan',
            'RO-PEG' => 'Biro Kepegawaian',
            'RO-KEU' => 'Biro Keuangan',
            'RO-KAP' => 'Biro Perlengkapan',
            'RO-HUK-HLN' => 'Biro Hukum dan Hubungan Luar Negeri',
            'RO-UMUM' => 'Biro Umum',
            'PUSDASKRIMTI' => 'Pusat Data Statistik Kriminal dan Teknologi Informasi',
            'PUSTRAJAKGAKUM' => 'Pusat Strategi Kebijakan Penegakan Hukum',
            'PKY' => 'Pusat Kesehatan Yustisial',
        ];

        foreach ($units as $kode => $nama) {
            UnitKerja::query()->updateOrCreate(
                ['kode' => $kode],
                ['nama' => $nama, 'parent_id' => $jambin->id, 'is_active' => true],
            );
        }
    }
}
