<?php

namespace Database\Seeders;

use App\Enums\NodeType;
use App\Models\Ss;
use Database\Seeders\Concerns\LoadsKinerjaDataset;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SsSeeder extends Seeder
{
    use LoadsKinerjaDataset;

    public function run(): void
    {
        DB::transaction(function (): void {
            $seen = [];

            foreach ($this->dataset()['strategics'] as $item) {
                if (isset($seen[$item['ss_code']])) {
                    continue;
                }

                $seen[$item['ss_code']] = true;
                $node = $this->upsertNode(NodeType::SS, $item['ss_code']);

                Ss::query()->updateOrCreate(
                    ['node_id' => $node->id],
                    [
                        'kode_ss' => $this->displayCode('SS', $item['ss_code']),
                        'nama_ss' => $item['ss_name'],
                        'penanggung_jawab_teks' => $item['responsible'] ?? null,
                    ],
                );
            }
        });
    }
}
