<?php

namespace App\Services\Calculation;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;

/** Decimal arithmetic; convert to the existing numeric API only at the boundary. */
final class Decimal
{
    public static function sum(array $values, int $scale = 4): float
    {
        $sum = BigDecimal::zero();
        foreach ($values as $value) $sum = $sum->plus((string) $value);
        return $sum->toScale($scale, RoundingMode::HALF_UP)->toFloat();
    }

    public static function weighted(array $values, array $weights): float
    {
        $sum = BigDecimal::zero();
        foreach ($values as $key => $value) {
            $sum = $sum->plus(BigDecimal::of((string) $value)->multipliedBy((string) $weights[$key]));
        }
        return $sum->toScale(4, RoundingMode::HALF_UP)->toFloat();
    }

    public static function ratio(mixed $numerator, mixed $denominator, int $scale = 4, int $factor = 100): float
    {
        return BigDecimal::of((string) $numerator)->multipliedBy($factor)
            ->dividedBy((string) $denominator, $scale, RoundingMode::HALF_UP)->toFloat();
    }

    public static function average(array $values): float
    {
        $sum = BigDecimal::zero();
        foreach ($values as $value) $sum = $sum->plus((string) $value);
        return $sum->dividedBy(count($values), 4, RoundingMode::HALF_UP)->toFloat();
    }
}
