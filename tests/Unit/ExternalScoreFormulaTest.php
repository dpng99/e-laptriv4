<?php

namespace Tests\Unit;

use App\Models\KinerjaNode;
use App\Services\Calculation\Calculators\ExternalScoreCalculator;
use App\Services\Calculation\FormulaContext;
use Tests\TestCase;

class ExternalScoreFormulaTest extends TestCase
{
    private ExternalScoreCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new ExternalScoreCalculator();
    }

    public function test_sakip_external_score_is_calculated_from_official_input(): void
    {
        $node = new KinerjaNode(['source_key' => 'IKP:1.1']);
        $context = new FormulaContext($node, ['nilai_sakip_resmi' => 84.55]);

        $result = $this->calculator->calculate($context);

        $this->assertSame(84.55, $result->value);
        $this->assertEmpty($result->warnings);
    }

    public function test_missing_external_score_returns_null_not_zero(): void
    {
        $node = new KinerjaNode(['source_key' => 'IKP:1.1']);
        $context = new FormulaContext($node, []);

        $result = $this->calculator->calculate($context);

        $this->assertNull($result->value);
        $this->assertNotEmpty($result->warnings);
    }
}
