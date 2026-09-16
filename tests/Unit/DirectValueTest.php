<?php

namespace Tests\Unit;

use App\Models\KinerjaNode;
use App\Services\Calculation\Calculators\DirectValueCalculator;
use App\Services\Calculation\FormulaContext;
use Tests\TestCase;

class DirectValueTest extends TestCase
{
    private DirectValueCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new DirectValueCalculator();
    }

    public function test_direct_value_calculated_with_realisasi_key(): void
    {
        $node = new KinerjaNode(['source_key' => 'IKK:10.8.2', 'calculation_type' => 'DIRECT_VALUE', 'formula_key' => 'DIRECT_VALUE']);
        $context = new FormulaContext($node, ['realisasi' => 3.75]);

        $result = $this->calculator->calculate($context);

        $this->assertSame(3.75, $result->value);
        $this->assertSame(['direct_value' => 3.75], $result->components);
        $this->assertEmpty($result->warnings);
    }

    public function test_direct_value_calculated_with_direct_value_or_nilai_alias(): void
    {
        $node = new KinerjaNode(['source_key' => 'IKK:10.8.2']);
        
        $context1 = new FormulaContext($node, ['direct_value' => 88.5]);
        $result1 = $this->calculator->calculate($context1);
        $this->assertSame(88.5, $result1->value);

        $context2 = new FormulaContext($node, ['nilai' => 92.1234]);
        $result2 = $this->calculator->calculate($context2);
        $this->assertSame(92.1234, $result2->value);
    }

    public function test_direct_value_missing_input_returns_null_with_warning(): void
    {
        $node = new KinerjaNode(['source_key' => 'IKK:10.8.2', 'calculation_type' => 'DIRECT_VALUE', 'formula_key' => 'DIRECT_VALUE']);
        $context = new FormulaContext($node, []);

        $result = $this->calculator->calculate($context);

        $this->assertNull($result->value);
        $this->assertContains('Nilai input belum diisi.', $result->warnings);
    }
}
