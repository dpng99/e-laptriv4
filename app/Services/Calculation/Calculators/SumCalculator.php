<?php

namespace App\Services\Calculation\Calculators;

use App\Services\Calculation\CalculationResult;
use App\Services\Calculation\FormulaCalculator;
use App\Services\Calculation\FormulaContext;

class SumCalculator implements FormulaCalculator
{
    public function calculate(FormulaContext $context): CalculationResult
    {
        $componentsConfig = $this->resolveComponents($context);

        if (empty($componentsConfig)) {
            return new CalculationResult(null, [], ['Komponen penjumlahan belum dikonfigurasi.']);
        }

        $total = 0.0;
        $componentValues = [];
        $missingComponents = [];

        foreach ($componentsConfig as $comp) {
            $key = $comp['key'];
            $val = $context->rawInputs[$key] ?? null;

            if ($val === null || $val === '') {
                $missingComponents[] = $key;
                $componentValues[$key] = null;
                continue;
            }

            $numVal = (float) $val;
            $componentValues[$key] = (string) $val;
            $total += $numVal;
        }

        if (!empty($missingComponents)) {
            return new CalculationResult(
                value: null,
                components: $componentValues,
                warnings: ['Komponen formula belum lengkap: ' . implode(', ', $missingComponents)],
            );
        }

        return new CalculationResult(
            value: \App\Services\Calculation\Decimal::sum($componentValues),
            components: $componentValues,
            warnings: [],
        );
    }

    private function resolveComponents(FormulaContext $context): array
    {
        return app(\App\Services\Calculation\ComponentResolver::class)->resolve($context);
    }
}
