<?php

namespace Tests\Unit;

use App\Models\KinerjaNode;
use App\Services\Calculation\Calculators\AverageOfRatiosCalculator;
use App\Services\Calculation\FormulaContext;
use Tests\TestCase;

class AverageOfRatiosTest extends TestCase
{
    private AverageOfRatiosCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new AverageOfRatiosCalculator();
    }

    public function test_ikp_11_2_calculates_average_of_two_ratios_from_four_counts(): void
    {
        $node = new KinerjaNode(['source_key' => 'IKP:11.2']);
        $context = new FormulaContext($node, [
            'jaksa_bersertifikat' => 60,
            'total_jaksa' => 100, // N1 = 60%
            'asn_non_jaksa_bersertifikat' => 160,
            'total_asn_non_jaksa' => 200, // N2 = 80%
        ]);

        $result = $this->calculator->calculate($context);

        // Average = (60 + 80) / 2 = 70%
        $this->assertSame(70.0, $result->value);
        $this->assertSame(60.0, $result->components['N1_persentase_jaksa']);
        $this->assertSame(80.0, $result->components['N2_persentase_asn_non_jaksa']);
    }

    public function test_zero_denominator_in_either_ratio_returns_null(): void
    {
        $node = new KinerjaNode(['source_key' => 'IKP:11.2']);
        $context = new FormulaContext($node, [
            'jaksa_bersertifikat' => 60,
            'total_jaksa' => 0,
            'asn_non_jaksa_bersertifikat' => 160,
            'total_asn_non_jaksa' => 200,
        ]);

        $result = $this->calculator->calculate($context);

        $this->assertNull($result->value);
        $this->assertNotEmpty($result->warnings);
    }
}
