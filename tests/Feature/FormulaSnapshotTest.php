<?php

namespace Tests\Feature;

use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use App\Models\Target;
use App\Models\UnitKerja;
use App\Services\CalculationEngine;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormulaSnapshotTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_snapshots_and_traces_are_persisted_upon_calculation(): void
    {
        $node = KinerjaNode::where('source_key', 'IKP:1.1')->firstOrFail();
        $unit = UnitKerja::firstOrFail();

        // Target: 85
        Target::updateOrCreate(
            ['node_id' => $node->id, 'tahun' => 2026],
            ['nilai_target' => 85, 'is_selected' => true]
        );

        // Operator enters official SAKIP score: 84.0
        $measurement = Pengukuran::updateOrCreate(
            ['node_id' => $node->id, 'unit_kerja_id' => $unit->id, 'tahun' => 2026, 'triwulan' => 4],
            ['realisasi' => 84.0]
        );

        $engine = app(CalculationEngine::class);
        $result = $engine->calculateNode($node, 2026, 4, $unit->id);

        $this->assertNotNull($result);
        $this->assertSame(84.0, (float) $result->realisasi);
        $this->assertSame(98.82, (float) $result->capaian);
        $this->assertSame(85.0, (float) $result->target_snapshot);
        $this->assertSame('EXTERNAL_SCORE', $result->formula_key_snapshot);
        $this->assertSame('1', $result->formula_version_snapshot);
        $this->assertSame('3.1', $result->calculation_trace['architecture_version']);
        $this->assertSame('TIDAK_TERCAPAI', $result->status_capaian); // < 100 in TW4
        $this->assertIsArray($result->calculation_trace);
        $this->assertSame('EXTERNAL_SCORE', $result->calculation_trace['formula_key']);
    }

    public function test_sakip_is_isolated_from_child_contribution_changes(): void
    {
        $sakipNode = KinerjaNode::where('source_key', 'IKP:1.1')->firstOrFail();
        $unit = UnitKerja::firstOrFail();

        Target::updateOrCreate(
            ['node_id' => $sakipNode->id, 'tahun' => 2026],
            ['nilai_target' => 85, 'is_selected' => true]
        );

        $measurement = Pengukuran::updateOrCreate(
            ['node_id' => $sakipNode->id, 'unit_kerja_id' => $unit->id, 'tahun' => 2026, 'triwulan' => 1],
            ['realisasi' => 85.0]
        );

        $engine = app(CalculationEngine::class);
        $engine->calculateNode($sakipNode, 2026, 1, $unit->id);

        // Now simulate child SK/IKK changing values
        $childSk = $sakipNode->childrenByRelation('CONTRIBUTION')->first();
        if ($childSk) {
            Pengukuran::updateOrCreate(
                ['node_id' => $childSk->id, 'unit_kerja_id' => $unit->id, 'tahun' => 2026, 'triwulan' => 1],
                ['realisasi' => 10.0]
            );
        }

        // Recalculate SAKIP node
        $refreshed = $engine->calculateNode($sakipNode, 2026, 1, $unit->id);

        // SAKIP must still be 85.0 (unaffected by child contribution!)
        $this->assertSame(85.0, (float) $refreshed->realisasi);
        $this->assertSame(100.0, (float) $refreshed->capaian);
        $this->assertSame('TERCAPAI', $refreshed->status_capaian);
    }
}
