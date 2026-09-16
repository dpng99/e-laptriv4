<?php

namespace App\Services\Calculation\Calculators;

use App\Services\Calculation\CalculationResult;
use App\Services\Calculation\FormulaCalculator;
use App\Services\Calculation\FormulaContext;

class UnfavorablePercentageCalculator implements FormulaCalculator
{
    public function calculate(FormulaContext $context): CalculationResult
    {
        $inputs = $context->rawInputs;
        $pembilang = $inputs['pembilang'] ?? $inputs['numerator'] ?? $inputs['X1'] ?? null;
        $penyebut = $inputs['penyebut'] ?? $inputs['denominator'] ?? $inputs['X2'] ?? null;

        if ($pembilang === null || $penyebut === null || $pembilang === '' || $penyebut === '') {
            return new CalculationResult(null, [], ['Data pembilang atau penyebut belum lengkap.']);
        }

        if ((float) $penyebut <= 0.0) {
            return new CalculationResult(null, [], ['Penyebut harus lebih besar dari 0.']);
        }

        $satuan = strtolower(trim($context->node->satuan ?? ''));
        $factor = 100;
        if (in_array($satuan, ['indeks', 'poin', 'nilai', 'skor', 'bulan', 'hari', 'jam', 'menit', 'buah', 'unit', 'dokumen'], true)) {
            $factor = 1;
        }

        $realisasi = (1 - ((float) $pembilang / (float) $penyebut)) * $factor;

        return new CalculationResult(
            value: round($realisasi, 4),
            components: [
                'pembilang' => (float) $pembilang,
                'penyebut' => (float) $penyebut,
                'formula' => $factor === 100 ? '(1 - ({pembilang} / {penyebut})) * 100' : '(1 - ({pembilang} / {penyebut}))',
            ],
            warnings: [],
        );
    }
}
