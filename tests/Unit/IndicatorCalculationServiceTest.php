<?php

namespace Tests\Unit;

use App\Enums\FormulaType;
use App\Models\RumusIndikator;
use App\Models\Target;
use App\Services\IndicatorCalculationService;
use Tests\TestCase;

class IndicatorCalculationServiceTest extends TestCase
{
    public function test_ratio_realisasi_is_separated_from_capaian_against_target(): void
    {
        $service = new IndicatorCalculationService();
        $rumus = new RumusIndikator([
            'tipe_formula' => FormulaType::RATIO_PERCENTAGE,
            'jumlah_desimal' => 2,
        ]);
        $target = new Target(['nilai_target' => 80]);

        $result = $service->calculateFromInputs($rumus, $target, 90, 100);

        $this->assertSame(90.0, $result['realisasi']);
        $this->assertSame(112.5, $result['capaian']);
    }

    public function test_direct_index_value_is_compared_to_target(): void
    {
        $service = new IndicatorCalculationService();
        $rumus = new RumusIndikator([
            'tipe_formula' => FormulaType::INDEX_SCORE,
            'jumlah_desimal' => 2,
        ]);
        $target = new Target(['nilai_target' => 4]);

        $result = $service->calculateFromInputs($rumus, $target, directValue: 3.5);

        $this->assertSame(3.5, $result['realisasi']);
        $this->assertSame(87.5, $result['capaian']);
    }

    public function test_lower_is_better_uses_inverse_target_comparison(): void
    {
        $service = new IndicatorCalculationService();
        $rumus = new RumusIndikator([
            'tipe_formula' => FormulaType::UNFAVORABLE_PERCENTAGE,
            'jumlah_desimal' => 2,
        ]);
        $target = new Target(['nilai_target' => 5]);

        $result = $service->calculateFromInputs($rumus, $target, directValue: 4);

        $this->assertSame(4.0, $result['realisasi']);
        $this->assertSame(125.0, $result['capaian']);
    }
}
