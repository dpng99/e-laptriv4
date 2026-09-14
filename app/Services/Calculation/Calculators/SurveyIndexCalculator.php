<?php

namespace App\Services\Calculation\Calculators;

use App\Services\Calculation\CalculationResult;
use App\Services\Calculation\FormulaCalculator;
use App\Services\Calculation\FormulaContext;

class SurveyIndexCalculator implements FormulaCalculator
{
    public function calculate(FormulaContext $context): CalculationResult
    {
        $inputs = $context->rawInputs;

        // Mode 1: total_skor_aktual and total_skor_maksimal
        if (array_key_exists('total_skor_aktual', $inputs) && array_key_exists('total_skor_maksimal', $inputs)) {
            $act = $inputs['total_skor_aktual'];
            $max = $inputs['total_skor_maksimal'];

            if ($act === null || $max === null || $act === '' || $max === '') {
                return new CalculationResult(null, [], ['Data skor survei belum lengkap.']);
            }

            $maxVal = (float) $max;
            if ($maxVal <= 0) {
                return new CalculationResult(null, [], ['Total skor maksimal survei harus lebih besar dari 0.']);
            }

            $score = ((float) $act / $maxVal) * 100;

            return new CalculationResult(
                value: round($score, 4),
                components: [
                    'total_skor_aktual' => (float) $act,
                    'total_skor_maksimal' => $maxVal,
                ],
                warnings: [],
            );
        }

        // Mode 2: TS, R, P, M (IKLH standard survey)
        if (isset($inputs['TS'], $inputs['R'], $inputs['P'], $inputs['M'])) {
            $ts = (float) $inputs['TS'];
            $r = (float) $inputs['R'];
            $p = (float) $inputs['P'];
            $m = (float) $inputs['M'];

            $denominator = $r * $p * $m;
            if ($denominator <= 0) {
                return new CalculationResult(null, [], ['Penyebut survei (R x P x M) harus lebih besar dari 0.']);
            }

            $score = ($ts / $denominator) * 100;

            return new CalculationResult(
                value: round($score, 4),
                components: ['TS' => $ts, 'R' => $r, 'P' => $p, 'M' => $m, 'penyebut' => $denominator],
                warnings: [],
            );
        }

        // Mode 3: Direct survey index value
        $direct = $inputs['nilai'] ?? $inputs['realisasi'] ?? $inputs['direct_value'] ?? null;
        if ($direct !== null && $direct !== '') {
            return new CalculationResult(
                value: round((float) $direct, 4),
                components: ['survey_score' => (float) $direct],
                warnings: [],
            );
        }

        return new CalculationResult(null, [], ['Data input survei belum lengkap.']);
    }
}
