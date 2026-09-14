<?php

namespace App\Services\Calculation\Calculators;

use App\Services\Calculation\CalculationResult;
use App\Services\Calculation\FormulaCalculator;
use App\Services\Calculation\FormulaContext;

class IndexScoreCalculator implements FormulaCalculator
{
    public function calculate(FormulaContext $context): CalculationResult
    {
        $inputs = $context->rawInputs;
        $pembilang = $inputs['pembilang'] ?? $inputs['skor_aktual'] ?? $inputs['X1'] ?? null;
        $penyebut = $inputs['penyebut'] ?? $inputs['skor_ideal'] ?? $inputs['X2'] ?? null;

        if ($pembilang === null || $penyebut === null || $pembilang === '' || $penyebut === '') {
            return new CalculationResult(null, [], ['Data skor aktual atau skor ideal belum lengkap.']);
        }

        if ((float) $penyebut <= 0.0) {
            return new CalculationResult(null, [], ['Skor ideal harus lebih besar dari 0.']);
        }

        $realisasi = ((float) $pembilang / (float) $penyebut) * 100;

        return new CalculationResult(
            value: round($realisasi, 4),
            components: [
                'skor_aktual' => (float) $pembilang,
                'skor_ideal' => (float) $penyebut,
            ],
            warnings: [],
        );
    }
}
