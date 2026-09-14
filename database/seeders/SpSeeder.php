<?php

namespace Database\Seeders;

use App\Enums\NodeType;
use App\Models\Sp;
use Database\Seeders\Concerns\LoadsKinerjaDataset;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpSeeder extends Seeder
{
    use LoadsKinerjaDataset;

    public function run(): void
    {
        DB::transaction(function (): void {
            $programs = [];

            foreach ($this->dataset()['programs'] as $item) {
                $programs[$item['parent_code']] = $item;
            }

            $names = $this->cascadingMap()['program_names'];

            foreach ($programs as $code => $item) {
                $node = $this->upsertNode(NodeType::SP, $code);

                Sp::query()->updateOrCreate(
                    ['node_id' => $node->id],
                    [
                        'kode_sp' => $this->displayCode('SP', $code),
                        'nama_sp' => $item['parent_name'],
                        'nama_program' => $names[$code] ?? $names['*'],
                        'penanggung_jawab_teks' => 'Jaksa Agung Muda Bidang Pembinaan',
                    ],
                );
            }
        });
    }
}
