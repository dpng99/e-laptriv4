<?php

namespace App\Services\Calculation\Calculators;

use App\Services\Calculation\CalculationResult;
use App\Services\Calculation\FormulaCalculator;
use App\Services\Calculation\FormulaContext;

class ExternalScoreCalculator implements FormulaCalculator
{
    public function calculate(FormulaContext $context): CalculationResult
    {
        $raw = $context->rawInputs['nilai_sakip_resmi']
            ?? $context->rawInputs['external_score']
            ?? $context->rawInputs['nilai']
            ?? $context->rawInputs['realisasi']
            ?? null;

        if ($raw === null || $raw === '') {
            return new CalculationResult(null, [], ['Nilai evaluasi eksternal resmi belum diisi.']);
        }

        $value = (float) $raw;

        return new CalculationResult(
            value: round($value, 4),
            components: ['external_score' => $value],
            warnings: [],
        );
    }
}
