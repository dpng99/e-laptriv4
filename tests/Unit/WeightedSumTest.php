<?php

namespace Tests\Unit;

use App\Models\KinerjaNode;
use App\Services\Calculation\Calculators\WeightedSumCalculator;
use App\Services\Calculation\FormulaContext;
use Tests\TestCase;

class WeightedSumTest extends TestCase
{
    private WeightedSumCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new WeightedSumCalculator();
    }

    public function test_ipa_weighted_sum_calculates_correctly(): void
    {
        $node = new KinerjaNode(['source_key' => 'IKP:5.1']);
        $context = new FormulaContext($node, [
            'X1' => 80, // 80 * 0.15 = 12
            'X2' => 90, // 90 * 0.10 = 9
            'X3' => 85, // 85 * 0.10 = 8.5
            'X4' => 70, // 70 * 0.10 = 7
            'X5' => 75, // 75 * 0.15 = 11.25
            'X6' => 80, // 80 * 0.10 = 8
            'X7' => 90, // 90 * 0.15 = 13.5
            'X8' => 85, // 85 * 0.15 = 12.75
            // Total = 12 + 9 + 8.5 + 7 + 11.25 + 8 + 13.5 + 12.75 = 82
        ]);

        $result = $this->calculator->calculate($context);

        $this->assertSame(82.0, $result->value);
        $this->assertEmpty($result->warnings);
    }

    public function test_ipa_missing_any_component_returns_null(): void
    {
        $node = new KinerjaNode(['source_key' => 'IKP:5.1']);
        $context = new FormulaContext($node, [
            'X1' => 80,
            'X2' => 90,
            // X3 missing
            'X4' => 70,
            'X5' => 75,
            'X6' => 80,
            'X7' => 90,
            'X8' => 85,
        ]);

        $result = $this->calculator->calculate($context);

        $this->assertNull($result->value);
        $this->assertNotEmpty($result->warnings);
    }
}
