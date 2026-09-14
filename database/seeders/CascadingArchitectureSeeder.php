<?php

namespace Database\Seeders;

use App\Models\KinerjaNode;
use App\Models\KomponenRumus;
use App\Models\RelasiKinerja;
use App\Models\RumusIndikator;
use Database\Seeders\Concerns\LoadsKinerjaDataset;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CascadingArchitectureSeeder extends Seeder
{
    use LoadsKinerjaDataset;

    public function run(): void
    {
        DB::transaction(function (): void {
            $architecture = require database_path('data/jambin_architecture_v3.php');

            $this->hydrateCanonicalNodeMetadata();
            $this->applyCanonicalArchitectureV3($architecture);
            KinerjaNode::where('jenis_node', 'IKK')->update(['input_enabled' => true]);
        });
    }

    private function hydrateCanonicalNodeMetadata(): void
    {
        foreach ($this->dataset()['strategics'] as $item) {
            $this->updateNode('SS', $item['ss_code'], $item['ss_name'] ?? null, null);
            $this->updateNode('IKSS', $item['indicator_code'], $item['indicator_name'] ?? null, $item['unit'] ?? null);
        }

        foreach ($this->dataset()['programs'] as $item) {
            $this->updateNode('SP', $item['parent_code'], $item['parent_name'] ?? null, null);
            $this->updateNode('IKP', $item['indicator_code'], $item['indicator_name'] ?? null, $item['unit'] ?? null);
        }

        foreach ($this->dataset()['activities'] as $item) {
            $this->updateNode('SK', $item['parent_code'], $item['parent_name'] ?? null, null);
            $this->updateNode('IKK', $item['indicator_code'], $item['indicator_name'] ?? null, $item['unit'] ?? null);
        }
    }

    private function updateNode(string $type, string $code, ?string $name, ?string $unit): void
    {
        $node = $this->node($type, $code);
        $node->update([
            'kode' => $this->displayCode($type, $code),
            'nama' => $name,
            'satuan' => $unit,
        ]);
    }

    private function applyCanonicalArchitectureV3(array $architecture): void
    {
        foreach ($architecture['indicators'] as $code => $meta) {
            $node = $this->node('IKP', $code);

            $calcType = match ($meta['formula_key']) {
                'EXTERNAL_SCORE' => 'EXTERNAL_SCORE',
                'RATIO_PERCENTAGE' => 'RATIO',
                'WEIGHTED_SUM' => 'WEIGHTED_SUM',
                'SUM' => 'SUM',
                'AVERAGE_COMPONENTS', 'AVERAGE_OF_RATIOS' => 'AVERAGE',
                'SURVEY_INDEX' => 'SURVEY_INDEX',
                default => $meta['formula_key'],
            };

            $node->ikp()->update(['measurement_mode' => $meta['tipe_node'] ?? 'MANDIRI']);
            // Administrator revisions own their formula metadata after initial normalization.
            if ($node->formulas()->where('versi', '>', 1)->exists()) continue;

            $node->update([
                'calculation_type' => $calcType,
                'formula_key' => $meta['formula_key'] ?? null,
                'input_enabled' => (bool) ($meta['input_enabled'] ?? false),
                'measurement_scope' => $meta['measurement_scope'] ?? 'UNIT',
            ]);

            $alreadyNormalized = $node->formulas()->where('status_formula', 'like', '%formula_key=%')->exists();
            if ($alreadyNormalized) continue;

            RumusIndikator::query()
                ->where('node_id', $node->id)
                ->where('is_active', true)
                ->update([
                    'tipe_formula' => $calcType,
                    'status_formula' => ($meta['formula_status'] ?? 'RESOLVED') . '; formula_key=' . ($meta['formula_key'] ?? ''),
                ]);

            // Seed formula components if defined
            $formula = RumusIndikator::query()->where('node_id', $node->id)->where('is_active', true)->first();
            if ($formula) {
                if (!empty($meta['formula_components'])) {
                    $formula->components()->whereIn('kode_komponen', ['pembilang', 'penyebut'])->delete();
                    foreach ($meta['formula_components'] as $index => $comp) {
                        KomponenRumus::query()->updateOrCreate(
                            [
                                'rumus_indikator_id' => $formula->id,
                                'kode_komponen' => $comp['key'],
                            ],
                            [
                                'nama_komponen' => $comp['name'],
                                'tipe_data' => 'DECIMAL',
                                'source_type' => 'INPUT',
                                'source_node_id' => null,
                                'input_key' => $comp['key'],
                                'aggregation' => null,
                                'bobot' => $comp['weight'] ?? null,
                                'urutan' => $index + 1,
                            ]
                        );
                    }
                } elseif ($meta['formula_key'] === 'EXTERNAL_SCORE') {
                    $formula->components()->delete();
                }
            }

            // Normalize relations to SK children
            $relationType = $meta['relation_semantics'] ?? 'CONTRIBUTION';
            $relations = RelasiKinerja::query()
                ->where('parent_node_id', $node->id)
                ->whereHas('child', fn ($q) => $q->where('jenis_node', 'SK'))
                ->get();

            $groupedByChild = $relations->groupBy('child_node_id');
            foreach ($groupedByChild as $childId => $childRelations) {
                $targetRel = $childRelations->firstWhere('jenis_relasi', $relationType);
                if ($targetRel) {
                    $childRelations->where('id', '!=', $targetRel->id)->each->delete();
                    $targetRel->update([
                        'catatan' => 'Semantik relasi dinormalisasi oleh CascadingArchitectureSeeder V3; relasi ini tidak otomatis menjadi operand formula.',
                    ]);
                } else {
                    $first = $childRelations->first();
                    if ($first) {
                        $first->update([
                            'jenis_relasi' => $relationType,
                            'catatan' => 'Semantik relasi dinormalisasi oleh CascadingArchitectureSeeder V3; relasi ini tidak otomatis menjadi operand formula.',
                        ]);
                        $childRelations->where('id', '!=', $first->id)->each->delete();
                    }
                }
            }

            // If explicit formula children exist, link them as FORMULA_COMPONENT
            if (!empty($meta['formula_children'])) {
                foreach ($meta['formula_children'] as $childKey) {
                    $childNode = KinerjaNode::where('source_key', $childKey)->first();
                    if ($childNode) {
                        RelasiKinerja::query()->updateOrCreate(
                            [
                                'parent_node_id' => $node->id,
                                'child_node_id' => $childNode->id,
                                'jenis_relasi' => 'FORMULA_COMPONENT',
                            ],
                            [
                                'dasar_relasi' => 'EXPLICIT',
                                'bobot' => null,
                                'catatan' => 'Operand langsung formula canonical V3',
                            ]
                        );
                    }
                }
            }
        }
    }
}
