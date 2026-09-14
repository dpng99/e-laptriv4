<?php

namespace App\Services\Calculation\Calculators;

use App\Services\Calculation\CalculationResult;
use App\Services\Calculation\FormulaCalculator;
use App\Services\Calculation\FormulaContext;

class DirectValueCalculator implements FormulaCalculator
{
    public function calculate(FormulaContext $context): CalculationResult
    {
        $raw = $context->rawInputs['nilai']
            ?? $context->rawInputs['direct_value']
            ?? $context->rawInputs['realisasi']
            ?? null;

        if ($raw === null || $raw === '') {
            return new CalculationResult(null, [], ['Nilai input belum diisi.']);
        }

        $value = (float) $raw;

        return new CalculationResult(
            value: round($value, 4),
            components: ['direct_value' => $value],
            warnings: [],
        );
    }
}
