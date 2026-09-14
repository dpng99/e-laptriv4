<?php

namespace Tests\Unit;

use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use App\Models\PengukuranInput;
use App\Models\UnitKerja;
use App\Services\Calculation\OrganizationalAggregationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizationalAggregationTest extends TestCase
{
    use RefreshDatabase;

    public function test_population_aggregation_sums_inputs_before_calculating_ratio(): void
    {
        $node = KinerjaNode::create([
            'source_key' => 'TEST:SOP',
            'jenis_node' => 'IKP',
            'formula_key' => 'RATIO_PERCENTAGE',
            'calculation_type' => 'RATIO',
            'input_enabled' => true,
            'is_active' => true,
        ]);

        $unitA = UnitKerja::create(['kode' => 'UNIT-A', 'nama' => 'Unit A', 'is_active' => true]);
        $unitB = UnitKerja::create(['kode' => 'UNIT-B', 'nama' => 'Unit B', 'is_active' => true]);

        // Unit A: 90/100 (90%)
        $pA = Pengukuran::create([
            'node_id' => $node->id,
            'unit_kerja_id' => $unitA->id,
            'tahun' => 2026,
            'triwulan' => 1,
            'realisasi' => 90,
        ]);
        PengukuranInput::create(['pengukuran_id' => $pA->id, 'input_key' => 'pembilang', 'nilai' => 90]);
        PengukuranInput::create(['pengukuran_id' => $pA->id, 'input_key' => 'penyebut', 'nilai' => 100]);

        // Unit B: 1/2 (50%)
        $pB = Pengukuran::create([
            'node_id' => $node->id,
            'unit_kerja_id' => $unitB->id,
            'tahun' => 2026,
            'triwulan' => 1,
            'realisasi' => 50,
        ]);
        PengukuranInput::create(['pengukuran_id' => $pB->id, 'input_key' => 'pembilang', 'nilai' => 1]);
        PengukuranInput::create(['pengukuran_id' => $pB->id, 'input_key' => 'penyebut', 'nilai' => 2]);

        $service = new OrganizationalAggregationService();
        $aggregated = $service->aggregate($node, 2026, 1, 'SUM_INPUTS_THEN_CALCULATE');

        // Population ratio: (90 + 1) / (100 + 2) * 100 = 91 / 102 * 100 = 89.2157%
        // NOT average of percentages: (90 + 50) / 2 = 70%
        $this->assertSame(89.2157, $aggregated);
    }
}
