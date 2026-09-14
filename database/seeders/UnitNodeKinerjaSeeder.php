<?php

namespace Database\Seeders;

use App\Models\KinerjaNode;
use App\Models\UnitKerja;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitNodeKinerjaSeeder extends Seeder
{
    public function run(): void
    {
        $patterns = [
            'Biro Perencanaan' => 'RO-REN',
            'Biro Kepegawaian' => 'RO-PEG',
            'Biro Keuangan' => 'RO-KEU',
            'Biro Perlengkapan' => 'RO-KAP',
            'Biro Hukum' => 'RO-HUK-HLN',
            'Biro hukum' => 'RO-HUK-HLN',
            'Biro Umum' => 'RO-UMUM',
            'Pusat Data Statistik' => 'PUSDASKRIMTI',
            'Pusdaskrimti' => 'PUSDASKRIMTI',
            'Pusat Strategi Kebijakan' => 'PUSTRAJAKGAKUM',
            'Pusat Kesehatan Yustisial' => 'PKY',
        ];

        DB::transaction(function () use ($patterns): void {
            foreach (KinerjaNode::query()->get() as $node) {
                $detail = match ($node->jenis_node->value) {
                    'SS' => $node->ss,
                    'IKSS' => $node->ikss,
                    'SP' => $node->sp,
                    'IKP' => $node->ikp,
                    'SK' => $node->sk,
                    'IKK' => $node->ikk,
                };

                $responsible = (string) ($detail?->penanggung_jawab_teks ?? '');
                $unitIds = [];

                foreach ($patterns as $needle => $unitCode) {
                    if (str_contains($responsible, $needle)) {
                        $unitIds[] = UnitKerja::query()->where('kode', $unitCode)->value('id');
                    }
                }

                $unitIds = array_values(array_unique(array_filter($unitIds)));

                if ($unitIds === []) {
                    $unitIds[] = UnitKerja::query()->where('kode', 'JAMBIN')->value('id');
                }

                foreach ($unitIds as $index => $unitId) {
                    DB::table('kinerja_unit_nodes')->updateOrInsert(
                        ['node_id' => $node->id, 'unit_kerja_id' => $unitId, 'peran' => $index === 0 ? 'OWNER' : 'CONTRIBUTOR'],
                        ['bobot' => null, 'created_at' => now(), 'updated_at' => now()],
                    );
                }
            }
        });
    }
}
