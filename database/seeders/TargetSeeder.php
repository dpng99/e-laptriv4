<?php

namespace Database\Seeders;

use App\Models\DokumenKinerja;
use App\Models\Target;
use Database\Seeders\Concerns\LoadsKinerjaDataset;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TargetSeeder extends Seeder
{
    use LoadsKinerjaDataset;

    public function run(): void
    {
        DB::transaction(function (): void {
            $kepjaId = DokumenKinerja::query()->where('kode', 'KEPJA-1184-2025')->value('id');
            $renstraId = DokumenKinerja::query()->where('kode', 'RENSTRA-KEJAKSAAN-2025-2029')->value('id');

            foreach ($this->dataset()['strategics'] as $item) {
                $this->storeIndicatorTargets('IKSS', $item, $kepjaId, $renstraId);
            }

            foreach ($this->dataset()['programs'] as $item) {
                $this->storeIndicatorTargets('IKP', $item, $kepjaId, $renstraId);
            }

            foreach ($this->dataset()['activities'] as $item) {
                $this->storeIndicatorTargets('IKK', $item, $kepjaId, $renstraId);
            }
        });
    }

    private function storeIndicatorTargets(string $type, array $item, int $kepjaId, int $renstraId): void
    {
        $node = $this->node($type, $item['indicator_code']);
        $comparison = $item['target_status'] ?? null;

        $this->storeSeries(
            $node->id,
            $kepjaId,
            $item['targets_kepja'] ?? [],
            $comparison,
            true,
            'Target berdasarkan KEPJA Nomor 1184 Tahun 2025.',
        );

        $this->storeSeries(
            $node->id,
            $renstraId,
            $item['targets_renstra'] ?? [],
            $comparison,
            false,
            'Target pembanding berdasarkan Renstra Kejaksaan RI 2025–2029.',
        );
    }

    private function storeSeries(
        int $nodeId,
        int $documentId,
        array $values,
        ?string $comparison,
        bool $selected,
        string $note,
    ): void {
        for ($index = 0; $index < 5; $index++) {
            $rawValue = $values[$index] ?? null;
            $number = $this->targetNumber($rawValue);
            $isConflict = $comparison !== null && str_contains(strtolower($comparison), 'beda');

            Target::query()->firstOrCreate(
                [
                    'node_id' => $nodeId,
                    'dokumen_kinerja_id' => $documentId,
                    'tahun' => 2025 + $index,
                    'periode' => 'TAHUNAN',
                ],
                [
                    'nilai_target' => $number,
                    'nilai_teks_sumber' => $rawValue === null ? null : (string) $rawValue,
                    'status' => $number === null ? 'NOT_SET' : ($isConflict ? 'CONFLICT' : 'OFFICIAL'),
                    'status_perbandingan' => $comparison,
                    'is_selected' => $selected,
                    'catatan' => $note,
                ],
            );
        }
    }
}
