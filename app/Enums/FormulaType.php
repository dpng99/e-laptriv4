<?php

namespace App\Enums;

enum FormulaType: string
{
    case DOCUMENTED = 'DOCUMENTED';
    case DIRECT_VALUE = 'DIRECT_VALUE';
    case EXTERNAL_SCORE = 'EXTERNAL_SCORE';
    case EXTERNAL_VALUE = 'EXTERNAL_VALUE';
    case RATIO = 'RATIO';
    case RATIO_PERCENTAGE = 'RATIO_PERCENTAGE';
    case LOWER_IS_BETTER = 'LOWER_IS_BETTER';
    case UNFAVORABLE_PERCENTAGE = 'UNFAVORABLE_PERCENTAGE';
    case AVERAGE = 'AVERAGE';
    case SUM = 'SUM';
    case WEIGHTED_SUM = 'WEIGHTED_SUM';
    case COUNT = 'COUNT';
    case INDEX_SCORE = 'INDEX_SCORE';
    case AVERAGE_COMPONENTS = 'AVERAGE_COMPONENTS';
    case AVERAGE_OF_RATIOS = 'AVERAGE_OF_RATIOS';
    case SURVEY_INDEX = 'SURVEY_INDEX';
    case CUSTOM = 'CUSTOM';
    case AGGREGATE_AVG = 'AGGREGATE_AVG';
    case CHILD_AGGREGATION = 'CHILD_AGGREGATION';
    case MANUAL = 'MANUAL';

    public static function normalize(self|string|null $value): self
    {
        if ($value instanceof self) {
            return $value;
        }

        return match (strtoupper((string) $value)) {
            'RATIO', 'RATIO_PERCENTAGE', 'PERCENTAGE' => self::RATIO,
            'LOWER_IS_BETTER', 'UNFAVORABLE', 'UNFAVORABLE_PERCENTAGE' => self::UNFAVORABLE_PERCENTAGE,
            'AGGREGATE', 'AGGREGATIVE', 'AGGREGATE_AVG', 'CHILD_AVERAGE', 'CHILD_AGGREGATION' => self::CHILD_AGGREGATION,
            'DIRECT', 'DIRECT_VALUE' => self::DIRECT_VALUE,
            'INDEX', 'INDEX_SCORE' => self::INDEX_SCORE,
            'EXTERNAL_SCORE' => self::EXTERNAL_SCORE,
            'EXTERNAL', 'EXTERNAL_VALUE' => self::EXTERNAL_VALUE,
            'WEIGHTED', 'WEIGHTED_SUM' => self::WEIGHTED_SUM,
            'AVERAGE' => self::AVERAGE,
            'SUM' => self::SUM,
            'COUNT' => self::COUNT,
            'SURVEY', 'SURVEY_INDEX' => self::SURVEY_INDEX,
            'CUSTOM' => self::CUSTOM,
            'MANUAL' => self::MANUAL,
            default => self::DOCUMENTED,
        };
    }

    public function isLowerIsBetter(): bool
    {
        return in_array($this, [self::LOWER_IS_BETTER, self::UNFAVORABLE_PERCENTAGE], true);
    }

    public function isChildAggregation(): bool
    {
        return in_array($this, [self::CHILD_AGGREGATION, self::AGGREGATE_AVG], true);
    }
}
