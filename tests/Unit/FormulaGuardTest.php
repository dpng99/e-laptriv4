<?php

namespace Tests\Unit;

use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use App\Services\Calculation\Calculators\AggregateAvgCalculator;
use App\Services\Calculation\Calculators\SumCalculator;
use App\Services\Calculation\Decimal;
use App\Services\Calculation\FormulaContext;
use App\Services\Calculation\FormulaRegistry;
use Tests\TestCase;

class FormulaGuardTest extends TestCase
{
    public function test_decimal_accumulation_and_population_ratio_are_deterministic(): void
    {
        $this->assertSame(0.3, Decimal::sum(['0.1', '0.2']));
        $this->assertSame(89.2157, Decimal::ratio('91', '102'));
        $this->assertSame(82.0, Decimal::weighted(['a' => '80', 'b' => '90'], ['a' => '0.8', 'b' => '0.2']));
    }

    public function test_sum_requires_configured_operands(): void
    {
        $context = new FormulaContext(new KinerjaNode(['source_key' => 'TEST:SUM']), ['realisasi' => 70, 'random_input' => 30]);
        $this->assertNull((new SumCalculator())->calculate($context)->value);
    }

    public function test_average_does_not_ignore_missing_child(): void
    {
        $context = new FormulaContext(new KinerjaNode(['source_key' => 'TEST:AVG']), [], childrenMeasurements: collect([
            new Pengukuran(['realisasi' => 80]), new Pengukuran(['realisasi' => null]),
        ]));
        $this->assertNull((new AggregateAvgCalculator())->calculate($context)->value);
    }

    public function test_custom_formula_is_not_implicitly_treated_as_survey(): void
    {
        $this->assertFalse((new FormulaRegistry())->has('CUSTOM'));
    }
}
