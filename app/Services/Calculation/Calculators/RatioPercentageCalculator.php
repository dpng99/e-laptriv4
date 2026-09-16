<?php

namespace App\Services\Calculation\Calculators;

use App\Services\Calculation\CalculationResult;
use App\Services\Calculation\FormulaCalculator;
use App\Services\Calculation\FormulaContext;

class RatioPercentageCalculator implements FormulaCalculator
{
    public function calculate(FormulaContext $context): CalculationResult
    {
        $inputs = $context->rawInputs;

        $pembilang = $this->resolveNumerator($inputs);
        $penyebut = $this->resolveDenominator($inputs);

        if ($pembilang === null || $penyebut === null) {
            return new CalculationResult(
                value: null,
                components: ['pembilang' => $pembilang, 'penyebut' => $penyebut],
                warnings: ['Data pembilang atau penyebut belum lengkap.'],
            );
        }

        if ((float) $penyebut <= 0.0) {
            return new CalculationResult(
                value: null,
                components: ['pembilang' => $pembilang, 'penyebut' => $penyebut],
                warnings: ['Penyebut harus lebih besar dari 0.'],
            );
        }

        $satuan = strtolower(trim($context->node->satuan ?? ''));
        $factor = 100;
        if (in_array($satuan, ['indeks', 'poin', 'nilai', 'skor', 'bulan', 'hari', 'jam', 'menit', 'buah', 'unit', 'dokumen'], true)) {
            $factor = 1;
        }

        $realisasi = \App\Services\Calculation\Decimal::ratio($pembilang, $penyebut, 4, $factor);

        return new CalculationResult(
            value: round($realisasi, 4),
            components: [
                'pembilang' => (float) $pembilang,
                'penyebut' => (float) $penyebut,
                'formula' => $factor === 100 ? '({pembilang} / {penyebut}) * 100' : '({pembilang} / {penyebut})',
            ],
            warnings: [],
        );
    }

    private function resolveNumerator(array $inputs): mixed
    {
        $keys = [
            'jumlah_satker_patuh',
            'skor_kompetensi_aktual',
            'proses_bisnis_terdigitalisasi',
            'sarpras_dimanfaatkan',
            'pembilang',
            'numerator',
            'S',
            'X1',
        ];

        foreach ($keys as $key) {
            if (array_key_exists($key, $inputs) && $inputs[$key] !== null && $inputs[$key] !== '') {
                return $inputs[$key];
            }
        }

        return null;
    }

    private function resolveDenominator(array $inputs): mixed
    {
        $keys = [
            'jumlah_satker_dinilai',
            'skor_kompetensi_ideal',
            'total_proses_bisnis_inti',
            'total_sarpras',
            'penyebut',
            'denominator',
            'T',
            'X2',
        ];

        foreach ($keys as $key) {
            if (array_key_exists($key, $inputs) && $inputs[$key] !== null && $inputs[$key] !== '') {
                return $inputs[$key];
            }
        }

        return null;
    }
}
