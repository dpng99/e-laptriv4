<?php

namespace App\Services\Calculation\Calculators;

use App\Services\Calculation\CalculationResult;
use App\Services\Calculation\FormulaCalculator;
use App\Services\Calculation\FormulaContext;

class AverageOfRatiosCalculator implements FormulaCalculator
{
    public function calculate(FormulaContext $context): CalculationResult
    {
        $inputs = $context->rawInputs;

        // Mode 1: 4 Raw Counts (Canonical IKP 11.2)
        if (
            array_key_exists('jaksa_bersertifikat', $inputs) ||
            array_key_exists('total_jaksa', $inputs) ||
            array_key_exists('asn_non_jaksa_bersertifikat', $inputs) ||
            array_key_exists('total_asn_non_jaksa', $inputs)
        ) {
            $jCert = $inputs['jaksa_bersertifikat'] ?? null;
            $jTotal = $inputs['total_jaksa'] ?? null;
            $nonJCert = $inputs['asn_non_jaksa_bersertifikat'] ?? null;
            $nonJTotal = $inputs['total_asn_non_jaksa'] ?? null;

            if ($jCert === null || $jTotal === null || $nonJCert === null || $nonJTotal === '' ||
                $jCert === '' || $jTotal === '' || $nonJCert === '' || $nonJTotal === null) {
                return new CalculationResult(null, [], ['Data 4 variabel sertifikasi belum lengkap.']);
            }

            $jTotalVal = (float) $jTotal;
            $nonJTotalVal = (float) $nonJTotal;

            if ($jTotalVal <= 0 || $nonJTotalVal <= 0) {
                return new CalculationResult(null, [], ['Total Jaksa dan Total ASN Non-Jaksa harus lebih besar dari 0.']);
            }

            $n1 = \App\Services\Calculation\Decimal::ratio($jCert, $jTotal, 12);
            $n2 = \App\Services\Calculation\Decimal::ratio($nonJCert, $nonJTotal, 12);
            $avg = \App\Services\Calculation\Decimal::average([$n1, $n2]);

            return new CalculationResult(
                value: round($avg, 4),
                components: [
                    'jaksa_bersertifikat' => (float) $jCert,
                    'total_jaksa' => $jTotalVal,
                    'asn_non_jaksa_bersertifikat' => (float) $nonJCert,
                    'total_asn_non_jaksa' => $nonJTotalVal,
                    'N1_persentase_jaksa' => round($n1, 4),
                    'N2_persentase_asn_non_jaksa' => round($n2, 4),
                ],
                warnings: [],
            );
        }

        // Mode 2: N1 and N2 directly provided as percentages
        $n1 = $inputs['N1'] ?? null;
        $n2 = $inputs['N2'] ?? null;

        if ($n1 !== null && $n2 !== null && $n1 !== '' && $n2 !== '') {
            $avg = \App\Services\Calculation\Decimal::average([$n1, $n2]);
            return new CalculationResult(
                value: round($avg, 4),
                components: ['N1' => (float) $n1, 'N2' => (float) $n2],
                warnings: [],
            );
        }

        return new CalculationResult(null, [], ['Variabel formula rasio belum diisi.']);
    }
}
