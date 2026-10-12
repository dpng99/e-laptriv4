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

        if ($context->node->source_key === 'IKP:7.2' || $context->node->kode === 'IKP 7.2') {
            $nilaiAwal = (float) \App\Services\Calculation\Decimal::sum($componentValues);
            $nilaiApresiasi = $nilaiAwal < 100.0 ? round((100.0 - $nilaiAwal) * 0.80, 4) : 0.0;
            $nilaiAkhir = min(100.0, round($nilaiAwal + $nilaiApresiasi, 4));

            return new CalculationResult(
                value: $nilaiAkhir,
                components: array_merge($componentValues, [
                    'nilai_awal' => $nilaiAwal,
                    'nilai_apresiasi' => $nilaiApresiasi,
                    'nilai_akhir' => $nilaiAkhir,
                    'formula_apresiasi' => 'X0 + (100 - X0) * 80%',
                ]),
                warnings: [],
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
