<?php

namespace Tests\Feature;

use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use App\Models\UnitKerja;
use App\Services\CalculationEngine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalculationGraphTest extends TestCase
{
    use RefreshDatabase;

    private function node(string $key, string $formula = 'DIRECT_VALUE'): KinerjaNode
    {
        return KinerjaNode::create([
            'source_key' => 'TEST:'.$key, 'jenis_node' => 'IKP',
            'formula_key' => $formula, 'input_enabled' => true, 'is_active' => true,
        ]);
    }

    private function link(KinerjaNode $parent, KinerjaNode $child, string $type = 'FORMULA_COMPONENT'): void
    {
        $parent->children()->attach($child->id, ['jenis_relasi' => $type, 'dasar_relasi' => 'EXPLICIT']);
    }

    public function test_dependencies_run_before_parent_and_contribution_is_excluded(): void
    {
        // Parent is inserted first so insertion order cannot satisfy the dependency.
        $parent = $this->node('PARENT', 'AGGREGATE_AVG');
        $child = $this->node('CHILD');
        $contribution = $this->node('CONTRIBUTION');
        $this->link($parent, $child);
        $this->link($parent, $contribution, 'CONTRIBUTION');
        $unit = UnitKerja::create(['kode' => 'GRAPH', 'nama' => 'Graph fixture', 'is_active' => true]);
        foreach ([[$child, 40], [$contribution, 100]] as [$node, $value]) {
            $measurement = Pengukuran::create(['node_id' => $node->id, 'unit_kerja_id' => $unit->id, 'tahun' => 2026, 'triwulan' => 1]);
            $measurement->inputs()->create(['input_key' => 'realisasi', 'nilai' => $value]);
        }
        app(CalculationEngine::class)->calculateAll(2026, 1, $unit->id);
        $this->assertSame(40.0, $parent->pengukurans()->sole()->realisasi);
        $this->assertSame(40.0, $child->pengukurans()->sole()->realisasi);

        $missing = $this->node('MISSING');
        $this->link($parent, $missing);
        app(CalculationEngine::class)->calculateAll(2026, 1, $unit->id);
        $this->assertNull($parent->pengukurans()->sole()->realisasi);
    }

    public function test_cycle_is_rejected_without_persisting_partial_calculations(): void
    {
        $first = $this->node('CYCLE_A', 'AGGREGATE_AVG');
        $second = $this->node('CYCLE_B', 'AGGREGATE_AVG');
        $this->link($first, $second);
        $this->link($second, $first);
        try {
            app(CalculationEngine::class)->calculateAll(2026, 1);
            $this->fail('Cyclic formula graph was accepted.');
        } catch (\RuntimeException $exception) {
            $this->assertStringContainsString('Siklus dependency', $exception->getMessage());
            $this->assertSame(0, Pengukuran::count());
        }
    }
}
