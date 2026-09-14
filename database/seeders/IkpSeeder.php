<?php

namespace Database\Seeders;

use App\Enums\NodeType;
use App\Models\Ikp;
use Database\Seeders\Concerns\LoadsKinerjaDataset;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IkpSeeder extends Seeder
{
    use LoadsKinerjaDataset;

    public function run(): void
    {
        DB::transaction(function (): void {
            $architecture = require database_path('data/jambin_architecture_v3.php');

            foreach ($this->dataset()['programs'] as $item) {
                $code = $this->plainCode('IKP', $item['indicator_code']);
                $node = $this->upsertNode(NodeType::IKP, $code);

                Ikp::query()->updateOrCreate(
                    ['node_id' => $node->id],
                    [
                        'kode_ikp' => $this->displayCode('IKP', $code),
                        'nama_ikp' => $item['indicator_name'],
                        'satuan' => $item['unit'] ?? null,
                        'measurement_mode' => $architecture['indicators'][$code]['tipe_node'] ?? 'MANDIRI',
                        'arah_kinerja' => 'HIGHER_IS_BETTER',
                        'penanggung_jawab_teks' => $item['responsible'] ?? null,
                        'penjelasan' => !empty($item['formula']) ? trim(preg_replace('/\s+/', ' ', str_replace(["\r\n", "\r"], "\n", $item['formula']))) : "Pengukuran indikator {$item['indicator_name']}.",
                    ],
                );
            }
        });
    }
}
