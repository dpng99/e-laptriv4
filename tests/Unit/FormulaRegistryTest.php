<?php

namespace Tests\Unit;

use App\Models\KinerjaNode;
use App\Services\Calculation\FormulaContext;
use App\Services\Calculation\FormulaRegistry;
use InvalidArgumentException;
use Tests\TestCase;

class FormulaRegistryTest extends TestCase
{
    private FormulaRegistry $registry;

    protected function setUp(): void
    {
        parent::setUp();
        $this->registry = new FormulaRegistry();
    }

    public function test_all_canonical_formula_keys_are_registered(): void
    {
        $keys = [
            'DIRECT_VALUE',
            'EXTERNAL_SCORE',
            'RATIO_PERCENTAGE',
            'RATIO',
            'UNFAVORABLE_PERCENTAGE',
            'INDEX_SCORE',
            'WEIGHTED_SUM',
            'SUM',
            'AVERAGE_COMPONENTS',
            'AVERAGE',
            'AVERAGE_OF_RATIOS',
            'SURVEY_INDEX',
            'COUNT',
            'AGGREGATE_AVG',
        ];

        foreach ($keys as $key) {
            $this->assertTrue($this->registry->has($key), "Key {$key} must be registered.");
        }
    }

    public function test_documented_only_and_unresolved_are_not_executable(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->registry->get('UNRESOLVED');
    }

    public function test_documented_only_returns_null_result_without_throwing(): void
    {
        $node = new KinerjaNode(['source_key' => 'TEST:1']);
        $context = new FormulaContext($node, ['x' => 10]);

        $result = $this->registry->calculate('DOCUMENTED_ONLY', $context);

        $this->assertNull($result->value);
        $this->assertNotEmpty($result->warnings);
    }
}
