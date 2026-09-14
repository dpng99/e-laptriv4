<?php

namespace Database\Seeders;

use App\Enums\NodeType;
use App\Models\Sk;
use Database\Seeders\Concerns\LoadsKinerjaDataset;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkSeeder extends Seeder
{
    use LoadsKinerjaDataset;

    public function run(): void
    {
        DB::transaction(function (): void {
            $sasaran = [];

            foreach ($this->dataset()['activities'] as $item) {
                $sasaran[$item['parent_code']] ??= $item;
            }

            foreach ($sasaran as $code => $item) {
                $node = $this->upsertNode(NodeType::SK, $code);

                Sk::query()->updateOrCreate(
                    ['node_id' => $node->id],
                    [
                        'kode_sk' => $this->displayCode('SK', $code),
                        'nama_sk' => $item['parent_name'],
                        'penanggung_jawab_teks' => $item['responsible'] ?? null,
                    ],
                );
            }
        });
    }
}
