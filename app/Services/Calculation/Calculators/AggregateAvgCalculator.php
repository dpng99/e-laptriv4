<?php

namespace App\Services\Calculation\Calculators;

use App\Services\Calculation\CalculationResult;
use App\Services\Calculation\FormulaCalculator;
use App\Services\Calculation\FormulaContext;

class AggregateAvgCalculator implements FormulaCalculator
{
    public function calculate(FormulaContext $context): CalculationResult
    {
        // Explicitly aggregated formula children only
        $measurements = $context->childrenMeasurements;

        if ($measurements->isEmpty()) {
            return new CalculationResult(null, [], ['Tidak ada data pengukuran child untuk diagregasikan.']);
        }

        $validValues = $measurements->pluck('realisasi')->filter(fn ($v) => $v !== null && $v !== '');

        if ($validValues->count() !== $measurements->count()) {
            return new CalculationResult(null, [], ['Seluruh nilai child belum diisi.']);
        }

        $avg = \App\Services\Calculation\Decimal::average($validValues->all());

        return new CalculationResult(
            value: round($avg, 4),
            components: [
                'total_children' => $measurements->count(),
                'filled_children' => $validValues->count(),
                'average' => $avg,
            ],
            warnings: [],
        );
    }
}
