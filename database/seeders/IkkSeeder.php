<?php

namespace Database\Seeders;

use App\Enums\NodeType;
use App\Models\Ikk;
use Database\Seeders\Concerns\LoadsKinerjaDataset;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IkkSeeder extends Seeder
{
    use LoadsKinerjaDataset;

    public function run(): void
    {
        DB::transaction(function (): void {
            foreach ($this->dataset()['activities'] as $item) {
                $code = $this->plainCode('IKK', $item['indicator_code']);
                $node = $this->upsertNode(NodeType::IKK, $code);

                Ikk::query()->updateOrCreate(
                    ['node_id' => $node->id],
                    [
                        'kode_ikk' => $this->displayCode('IKK', $code),
                        'kode_sumber' => $this->displayCode('IKK', $item['source_indicator_code'] ?? $code),
                        'nama_ikk' => $item['indicator_name'],
                        'satuan' => $item['unit'] ?? null,
                        'measurement_mode' => 'DIRECT',
                        'arah_kinerja' => 'HIGHER_IS_BETTER',
                        'penanggung_jawab_teks' => $item['responsible'] ?? null,
                        'penjelasan' => !empty($item['formula']) ? trim(preg_replace('/\s+/', ' ', str_replace(["\r\n", "\r"], "\n", $item['formula']))) : "Pengukuran indikator {$item['indicator_name']}.",
                    ],
                );
            }
        });
    }
}
