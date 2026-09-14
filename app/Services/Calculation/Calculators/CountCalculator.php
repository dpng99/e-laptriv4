<?php

namespace App\Services\Calculation\Calculators;

use App\Services\Calculation\CalculationResult;
use App\Services\Calculation\FormulaCalculator;
use App\Services\Calculation\FormulaContext;

class CountCalculator implements FormulaCalculator
{
    public function calculate(FormulaContext $context): CalculationResult
    {
        $inputs = $context->rawInputs;
        $count = $inputs['jumlah'] ?? $inputs['count'] ?? $inputs['nilai'] ?? $inputs['realisasi'] ?? null;

        if ($count === null || $count === '') {
            return new CalculationResult(null, [], ['Data jumlah belum diisi.']);
        }

        $val = (float) $count;

        return new CalculationResult(
            value: round($val, 4),
            components: ['count' => $val],
            warnings: [],
        );
    }
}
