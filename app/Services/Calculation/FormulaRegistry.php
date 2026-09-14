<?php

namespace App\Services\Calculation;

use App\Services\Calculation\Calculators\AggregateAvgCalculator;
use App\Services\Calculation\Calculators\AverageComponentsCalculator;
use App\Services\Calculation\Calculators\AverageOfRatiosCalculator;
use App\Services\Calculation\Calculators\CountCalculator;
use App\Services\Calculation\Calculators\DirectValueCalculator;
use App\Services\Calculation\Calculators\ExternalScoreCalculator;
use App\Services\Calculation\Calculators\IndexScoreCalculator;
use App\Services\Calculation\Calculators\RatioPercentageCalculator;
use App\Services\Calculation\Calculators\SumCalculator;
use App\Services\Calculation\Calculators\SurveyIndexCalculator;
use App\Services\Calculation\Calculators\UnfavorablePercentageCalculator;
use App\Services\Calculation\Calculators\WeightedSumCalculator;
use InvalidArgumentException;

class FormulaRegistry
{
    /** @var array<string, FormulaCalculator> */
    private array $calculators = [];

    public function __construct()
    {
        $this->registerDefaults();
    }

    private function registerDefaults(): void
    {
        $direct = new DirectValueCalculator();
        $external = new ExternalScoreCalculator();
        $ratio = new RatioPercentageCalculator();
        $unfavorable = new UnfavorablePercentageCalculator();
        $indexScore = new IndexScoreCalculator();
        $weightedSum = new WeightedSumCalculator();
        $sum = new SumCalculator();
        $avgComponents = new AverageComponentsCalculator();
        $avgOfRatios = new AverageOfRatiosCalculator();
        $surveyIndex = new SurveyIndexCalculator();
        $count = new CountCalculator();
        $aggregateAvg = new AggregateAvgCalculator();

        $this->register('DIRECT_VALUE', $direct);
        $this->register('EXTERNAL_SCORE', $external);
        $this->register('RATIO_PERCENTAGE', $ratio);
        $this->register('RATIO', $ratio);
        $this->register('UNFAVORABLE_PERCENTAGE', $unfavorable);
        $this->register('INDEX_SCORE', $indexScore);
        $this->register('WEIGHTED_SUM', $weightedSum);
        $this->register('SUM', $sum);
        $this->register('AVERAGE_COMPONENTS', $avgComponents);
        $this->register('AVERAGE', $avgComponents);
        $this->register('AVERAGE_OF_RATIOS', $avgOfRatios);
        $this->register('SURVEY_INDEX', $surveyIndex);
        $this->register('COUNT', $count);
        $this->register('AGGREGATE_AVG', $aggregateAvg);
        $this->register('EXTERNAL_VALUE', $external);
        $this->register('MANUAL', $direct);
    }

    public function register(string $key, FormulaCalculator $calculator): self
    {
        $this->calculators[strtoupper(trim($key))] = $calculator;
        return $this;
    }

    public function has(string $key): bool
    {
        $normalized = strtoupper(trim($key));
        return isset($this->calculators[$normalized]);
    }

    public function get(string $key): FormulaCalculator
    {
        $normalized = strtoupper(trim($key));

        if (in_array($normalized, ['DOCUMENTED', 'DOCUMENTED_ONLY', 'UNRESOLVED'], true)) {
            throw new InvalidArgumentException("Formula status '{$normalized}' bukan formula executable.");
        }

        if (!isset($this->calculators[$normalized])) {
            throw new InvalidArgumentException("Formula calculator untuk key '{$key}' tidak terdaftar.");
        }

        return $this->calculators[$normalized];
    }

    public function calculate(string $key, FormulaContext $context): CalculationResult
    {
        $normalized = strtoupper(trim($key));

        if (in_array($normalized, ['DOCUMENTED', 'DOCUMENTED_ONLY', 'UNRESOLVED'], true)) {
            return new CalculationResult(
                value: null,
                components: [],
                warnings: ["Formula berstatus '{$normalized}' dan tidak dieksekusi secara otomatis."],
            );
        }

        return $this->get($normalized)->calculate($context);
    }
}
