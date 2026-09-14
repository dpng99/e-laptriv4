<?php

namespace App\Enums;

enum MeasurementMode: string
{
    case NONE = 'NONE';
    case DIRECT = 'DIRECT';
    case MANDIRI = 'MANDIRI';
    case AGGREGATE = 'AGGREGATE';
    case AGREGATIF = 'AGREGATIF';
    case HYBRID = 'HYBRID';

    public static function normalize(self|string|null $value): self
    {
        if ($value instanceof self) {
            return $value;
        }

        return match (strtoupper((string) $value)) {
            'DIRECT', 'MANDIRI', 'LEAF' => self::DIRECT,
            'AGGREGATE', 'AGREGATIF', 'HYBRID', 'ROLLUP', 'ROLL_UP' => self::AGGREGATE,
            default => self::NONE,
        };
    }

    public function isDirect(): bool
    {
        return in_array($this, [self::DIRECT, self::MANDIRI], true);
    }

    public function isAggregate(): bool
    {
        return in_array($this, [self::AGGREGATE, self::AGREGATIF, self::HYBRID], true);
    }
}
