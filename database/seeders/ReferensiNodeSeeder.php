<?php

namespace Database\Seeders;

use App\Models\DokumenKinerja;
use App\Models\ReferensiNode;
use Database\Seeders\Concerns\LoadsKinerjaDataset;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferensiNodeSeeder extends Seeder
{
    use LoadsKinerjaDataset;

    public function run(): void
    {
        DB::transaction(function (): void {
            $kepjaId = DokumenKinerja::query()->where('kode', 'KEPJA-1184-2025')->value('id');

            foreach ($this->dataset()['strategics'] as $item) {
                $this->storeReference('SS', $item['ss_code'], $kepjaId, $item['ss_code'], $item['page'] ?? null);
                $this->storeReference('IKSS', $item['indicator_code'], $kepjaId, $item['indicator_code'], $item['page'] ?? null);
            }

            foreach ($this->dataset()['programs'] as $item) {
                $this->storeReference('SP', $item['parent_code'], $kepjaId, 'SP '.$item['parent_code'], $item['page'] ?? null);
                $this->storeReference('IKP', $item['indicator_code'], $kepjaId, 'IKP '.($item['source_indicator_code'] ?? $item['indicator_code']), $item['page'] ?? null);
            }

            foreach ($this->dataset()['activities'] as $item) {
                $this->storeReference('SK', $item['parent_code'], $kepjaId, 'SK '.$item['parent_code'], $item['page'] ?? null);
                $sourceCode = $item['source_indicator_code'] ?? $item['indicator_code'];
                $note = $sourceCode !== $item['indicator_code']
                    ? 'Kode dinormalisasi dari '.$sourceCode.' menjadi '.$item['indicator_code'].'.'
                    : null;

                $this->storeReference('IKK', $item['indicator_code'], $kepjaId, 'IKK '.$sourceCode, $item['page'] ?? null, $note);
            }
        });
    }

    private function storeReference(
        string $type,
        string $code,
        int $documentId,
        string $sourceCode,
        ?int $page,
        ?string $note = null,
    ): void {
        $node = $this->node($type, $code);

        ReferensiNode::query()->updateOrCreate(
            [
                'node_id' => $node->id,
                'dokumen_kinerja_id' => $documentId,
                'halaman' => $page,
            ],
            ['kode_sumber' => $sourceCode, 'catatan' => $note],
        );
    }
}
