<?php

namespace Database\Seeders;

use App\Models\DokumenKinerja;
use App\Models\RelasiKinerja;
use Database\Seeders\Concerns\LoadsKinerjaDataset;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelasiKinerjaSeeder extends Seeder
{
    use LoadsKinerjaDataset;

    public function run(): void
    {
        DB::transaction(function (): void {
            $data = $this->dataset();
            $map = $this->cascadingMap();
            $kepjaId = DokumenKinerja::query()->where('kode', 'KEPJA-1184-2025')->value('id');

            foreach ($data['strategics'] as $item) {
                $this->connect(
                    'SS', $item['ss_code'], 'IKSS', $item['indicator_code'],
                    'STRUCTURAL', 'EXPLICIT', $kepjaId, $item['page'] ?? null,
                    'Hubungan sasaran strategis dan indikatornya dalam KEPJA.',
                );
            }

            $seenSp = [];
            foreach ($data['programs'] as $item) {
                $spCode = (string) $item['parent_code'];
                if (isset($seenSp[$spCode])) {
                    continue;
                }
                $seenSp[$spCode] = true;
                $ikssCode = $map['strategic_indicator_by_sp'][$spCode]
                    ?? $map['strategic_indicator_by_sp']['*'];

                $this->connect(
                    'IKSS', $ikssCode, 'SP', $spCode,
                    $spCode === '18' ? 'REFERENCE' : 'CASCADING',
                    'ANALYTICAL', null, null,
                    $spCode === '18'
                        ? 'Jalur lintas-program sebagai referensi/enabler; bukan operand kalkulasi.'
                        : 'Crosswalk tata kelola organisasi ke Program Dukungan Manajemen.',
                );
            }

            foreach ($data['programs'] as $item) {
                $this->connect(
                    'SP', $item['parent_code'], 'IKP', $item['indicator_code'],
                    'STRUCTURAL', 'EXPLICIT', $kepjaId, $item['page'] ?? null,
                    'Hubungan sasaran program dan indikator program dalam KEPJA.',
                );
            }

            foreach ($map['ikp_to_sk'] as $ikpCode => $skCodes) {
                foreach ($skCodes as $skCode) {
                    $this->connect(
                        'IKP', $ikpCode, 'SK', $skCode,
                        'CASCADING', 'ANALYTICAL', null, null,
                        'Pemetaan outcome-output awal; CascadingArchitectureSeeder menetapkan semantik final CONTRIBUTION/FORMULA_COMPONENT/SAME_INDICATOR/ORG_AGGREGATION.',
                    );
                }
            }

            foreach ($data['activities'] as $item) {
                $this->connect(
                    'SK', $item['parent_code'], 'IKK', $item['indicator_code'],
                    'STRUCTURAL', 'EXPLICIT', $kepjaId, $item['page'] ?? null,
                    'Hubungan sasaran kegiatan dan indikator kegiatan dalam KEPJA.',
                );
            }
        });
    }

    private function connect(
        string $parentType,
        string $parentCode,
        string $childType,
        string $childCode,
        string $relationType,
        string $basis,
        ?int $documentId,
        ?int $page,
        ?string $note,
    ): void {
        $parent = $this->node($parentType, $parentCode);
        $child = $this->node($childType, $childCode);

        RelasiKinerja::query()->updateOrCreate(
            [
                'parent_node_id' => $parent->id,
                'child_node_id' => $child->id,
                'jenis_relasi' => $relationType,
            ],
            [
                'dasar_relasi' => $basis,
                'bobot' => null,
                'dokumen_kinerja_id' => $documentId,
                'halaman_sumber' => $page,
                'catatan' => $note,
            ],
        );
    }
}
