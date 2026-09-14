<?php

namespace App\Services\Calculation\Calculators;

use App\Services\Calculation\CalculationResult;
use App\Services\Calculation\FormulaCalculator;
use App\Services\Calculation\FormulaContext;

class AverageComponentsCalculator implements FormulaCalculator
{
    public function calculate(FormulaContext $context): CalculationResult
    {
        $componentsConfig = $this->resolveComponents($context);

        if (empty($componentsConfig)) {
            // If formula children exist in calculation context (explicit formula children)
            if ($context->childrenMeasurements->isNotEmpty()) {
                $values = $context->childrenMeasurements->pluck('realisasi')->filter(fn ($v) => $v !== null);
                if ($values->count() !== $context->childrenMeasurements->count()) {
                    return new CalculationResult(null, [], ['Nilai child indikator belum tersedia.']);
                }
                return new CalculationResult(
                    value: \App\Services\Calculation\Decimal::average($values->all()),
                    components: $values->toArray(),
                    warnings: [],
                );
            }

            return new CalculationResult(null, [], ['Komponen rata-rata belum dikonfigurasi.']);
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

        $count = count($componentsConfig);
        $avg = $count > 0 ? $total / $count : 0.0;

        return new CalculationResult(
            value: \App\Services\Calculation\Decimal::average($componentValues),
            components: $componentValues,
            warnings: [],
        );
    }

    private function resolveComponents(FormulaContext $context): array
    {
        return app(\App\Services\Calculation\ComponentResolver::class)->resolve($context);
    }
}
