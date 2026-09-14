<?php

namespace App\Services\Calculation\Calculators;

use App\Services\Calculation\CalculationResult;
use App\Services\Calculation\FormulaCalculator;
use App\Services\Calculation\FormulaContext;

class WeightedSumCalculator implements FormulaCalculator
{
    public function calculate(FormulaContext $context): CalculationResult
    {
        $componentsConfig = $this->resolveComponents($context);

        if (empty($componentsConfig)) {
            return new CalculationResult(null, [], ['Komponen pembobotan belum dikonfigurasi.']);
        }

        $totalWeight = 0.0;
        foreach ($componentsConfig as $comp) {
            $totalWeight += (float) ($comp['weight'] ?? 0.0);
        }

        if ($totalWeight <= 0.0) {
            return new CalculationResult(null, [], ['Komponen pembobotan belum dikonfigurasi dengan bobot yang valid (total bobot = 0).']);
        }

        $total = 0.0;
        $componentValues = [];
        $missingComponents = [];

        foreach ($componentsConfig as $comp) {
            $key = $comp['key'];
            $weight = (float) ($comp['weight'] ?? 0.0);

            $val = $context->rawInputs[$key] ?? null;

            if ($val === null || $val === '') {
                $missingComponents[] = $key;
                $componentValues[$key] = null;
                continue;
            }

            $numVal = (float) $val;
            $componentValues[$key] = [
                'nilai' => $numVal,
                'bobot' => $weight,
                'kontribusi' => round($numVal * $weight, 4),
            ];

            $total += ($numVal * $weight);
        }

        if (!empty($missingComponents)) {
            return new CalculationResult(
                value: null,
                components: $componentValues,
                warnings: ['Komponen formula belum lengkap: ' . implode(', ', $missingComponents)],
            );
        }

        return new CalculationResult(
            value: \App\Services\Calculation\Decimal::weighted(
                array_intersect_key($context->rawInputs, array_flip(array_column($componentsConfig, 'key'))),
                array_column($componentsConfig, 'weight', 'key'),
            ),
            components: $componentValues,
            warnings: [],
        );
    }

    private function resolveComponents(FormulaContext $context): array
    {
        return app(\App\Services\Calculation\ComponentResolver::class)->resolve($context);
    }
}
