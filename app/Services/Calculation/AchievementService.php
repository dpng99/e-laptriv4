<?php

namespace App\Services\Calculation;

class AchievementService
{
    public function calculate(
        ?float $realisasi,
        ?float $target,
        string $polarity = 'MAXIMIZE',
        ?float $cap = null,
        int $precision = 2
    ): ?float {
        if ($realisasi === null || $target === null || $target <= 0.0) {
            return null;
        }

        $normPolarity = strtoupper(trim($polarity));

        if ($normPolarity === 'MINIMIZE' || $normPolarity === 'LOWER_IS_BETTER') {
            if ($realisasi <= 0.0) {
                return null;
            }
            $achievement = Decimal::ratio($target, $realisasi, $precision);
        } else {
            $achievement = Decimal::ratio($realisasi, $target, $precision);
        }

        if ($cap !== null && $cap > 0.0) {
            $achievement = min($achievement, $cap);
        }

        return round($achievement, $precision);
    }
}
