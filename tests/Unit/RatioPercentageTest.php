<?php

namespace Tests\Unit;

use App\Models\KinerjaNode;
use App\Services\Calculation\Calculators\RatioPercentageCalculator;
use App\Services\Calculation\FormulaContext;
use Tests\TestCase;

class RatioPercentageTest extends TestCase
{
    private RatioPercentageCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new RatioPercentageCalculator();
    }

    public function test_sop_compliance_ratio_is_calculated_correctly(): void
    {
        $node = new KinerjaNode(['source_key' => 'IKP:6.2']);
        $context = new FormulaContext($node, [
            'jumlah_satker_patuh' => 420,
            'jumlah_satker_dinilai' => 500,
        ]);

        $result = $this->calculator->calculate($context);

        $this->assertSame(84.0, $result->value);
        $this->assertEmpty($result->warnings);
    }

    public function test_zero_denominator_returns_null_with_warning(): void
    {
        $node = new KinerjaNode(['source_key' => 'IKP:6.2']);
        $context = new FormulaContext($node, [
            'jumlah_satker_patuh' => 0,
            'jumlah_satker_dinilai' => 0,
        ]);

        $result = $this->calculator->calculate($context);

        $this->assertNull($result->value);
        $this->assertContains('Penyebut harus lebih besar dari 0.', $result->warnings);
    }

    public function test_missing_input_returns_null_not_zero(): void
    {
        $node = new KinerjaNode(['source_key' => 'IKP:6.2']);
        $context = new FormulaContext($node, [
            'jumlah_satker_patuh' => 10,
        ]);

        $result = $this->calculator->calculate($context);

        $this->assertNull($result->value);
        $this->assertNotEmpty($result->warnings);
    }
}
