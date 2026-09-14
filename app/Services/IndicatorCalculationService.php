<?php

namespace App\Services;

use App\Enums\FormulaType;
use App\Models\RumusIndikator;
use App\Models\Target;

class IndicatorCalculationService
{
    /**
     * Hitung realisasi operasional terlebih dahulu, lalu capaian terhadap target.
     */
    public function calculateFromInputs(
        ?RumusIndikator $rumus,
        ?Target $target,
        mixed $pembilang = null,
        mixed $penyebut = null,
        mixed $directValue = null,
    ): array {
        $formulaType = FormulaType::normalize($rumus?->tipe_formula);
        $realisasi = $this->calculateRealisasi($formulaType, $pembilang, $penyebut, $directValue);
        $capaian = $this->calculateCapaian($formulaType, $realisasi, $target, $rumus);

        return [
            'realisasi' => $realisasi,
            'capaian' => $capaian,
            'formula_type' => $formulaType->value,
        ];
    }

    public function calculateCapaian(
        FormulaType|string|null $formulaType,
        mixed $realisasi,
        ?Target $target,
        ?RumusIndikator $rumus = null,
    ): ?float {
        $type = FormulaType::normalize($formulaType);
        $actual = $this->number($realisasi);
        $targetValue = $this->number($target?->nilai_target);

        if ($actual === null || $targetValue === null || $targetValue <= 0) {
            return null;
        }

        if ($type->isLowerIsBetter()) {
            if ($actual <= 0) {
                return null;
            }

            $value = ($targetValue / $actual) * 100;
        } else {
            $value = ($actual / $targetValue) * 100;
        }

        $cap = $this->number($rumus?->batas_capaian);
        if ($cap !== null && $cap > 0) {
            $value = min($value, $cap);
        }

        return $this->round($value, $rumus);
    }

    private function calculateRealisasi(
        FormulaType $formulaType,
        mixed $pembilang,
        mixed $penyebut,
        mixed $directValue,
    ): ?float {
        return match ($formulaType) {
            FormulaType::RATIO,
            FormulaType::RATIO_PERCENTAGE => $this->ratioPercentage($pembilang, $penyebut),

            FormulaType::LOWER_IS_BETTER,
            FormulaType::UNFAVORABLE_PERCENTAGE => $this->bestAvailableValue($pembilang, $penyebut, $directValue),

            FormulaType::DIRECT_VALUE,
            FormulaType::INDEX_SCORE,
            FormulaType::EXTERNAL_VALUE,
            FormulaType::MANUAL => $this->number($directValue ?? $pembilang),

            FormulaType::WEIGHTED_SUM,
            FormulaType::AVERAGE,
            FormulaType::SURVEY_INDEX,
            FormulaType::DOCUMENTED => $this->bestAvailableValue($pembilang, $penyebut, $directValue),

            FormulaType::CHILD_AGGREGATION,
            FormulaType::AGGREGATE_AVG => null,
        };
    }

    private function ratioPercentage(mixed $pembilang, mixed $penyebut): ?float
    {
        $numerator = $this->number($pembilang);
        $denominator = $this->number($penyebut);

        if ($numerator === null || $denominator === null || $denominator <= 0) {
            return null;
        }

        return round(($numerator / $denominator) * 100, 4);
    }

    private function bestAvailableValue(mixed $pembilang, mixed $penyebut, mixed $directValue): ?float
    {
        $direct = $this->number($directValue);
        if ($direct !== null) {
            return $direct;
        }

        $ratio = $this->ratioPercentage($pembilang, $penyebut);
        if ($ratio !== null) {
            return $ratio;
        }

        return $this->number($pembilang);
    }

    private function round(float $value, ?RumusIndikator $rumus): float
    {
        $decimals = (int) ($rumus?->jumlah_desimal ?? 2);

        return round($value, max(0, min($decimals, 4)));
    }

    private function number(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_string($value)) {
            $value = str_replace(',', '.', trim($value));
        }

        return is_numeric($value) ? (float) $value : null;
    }
}
