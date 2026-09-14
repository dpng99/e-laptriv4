<?php

namespace Database\Seeders;

use App\Enums\NodeType;
use App\Models\Ikss;
use Database\Seeders\Concerns\LoadsKinerjaDataset;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IkssSeeder extends Seeder
{
    use LoadsKinerjaDataset;

    public function run(): void
    {
        DB::transaction(function (): void {
            foreach ($this->dataset()['strategics'] as $item) {
                $node = $this->upsertNode(NodeType::IKSS, $item['indicator_code']);

                Ikss::query()->updateOrCreate(
                    ['node_id' => $node->id],
                    [
                        'kode_ikss' => $this->displayCode('IKSS', $item['indicator_code']),
                        'nama_ikss' => $item['indicator_name'],
                        'satuan' => $item['unit'] ?? null,
                        'measurement_mode' => 'DIRECT',
                        'arah_kinerja' => 'HIGHER_IS_BETTER',
                        'penanggung_jawab_teks' => $item['responsible'] ?? null,
                    ],
                );
            }
        });
    }
}
