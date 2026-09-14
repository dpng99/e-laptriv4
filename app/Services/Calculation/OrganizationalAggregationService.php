<?php

namespace App\Services\Calculation;

use App\Models\KinerjaNode;
use App\Models\Pengukuran;
use App\Models\PengukuranInput;
use Illuminate\Support\Collection;

class OrganizationalAggregationService
{
    public function __construct(
        private readonly FormulaRegistry $formulaRegistry = new FormulaRegistry(),
    ) {}

    /**
     * Aggregate measurements across organizational units for a given node and period.
     */
    public function aggregate(
        KinerjaNode $node,
        int $tahun,
        int $triwulan,
        string $method = 'SUM_INPUTS_THEN_CALCULATE'
    ): ?float {
        $measurements = Pengukuran::query()
            ->where('node_id', $node->id)
            ->where('tahun', $tahun)
            ->where('triwulan', $triwulan)
            ->whereNotNull('unit_kerja_id')
            ->get();

        if ($measurements->isEmpty()) {
            return null;
        }

        return match (strtoupper(trim($method))) {
            'SUM_INPUTS_THEN_CALCULATE' => $this->sumInputsThenCalculate($node, $measurements),
            'SUM' => $this->sumRealization($measurements),
            'AVERAGE' => $this->averageRealization($measurements),
            'DIRECT_OVERRIDE' => null, // Managed at organization level
            default => throw new \InvalidArgumentException('Metode agregasi organisasi tidak dikenal.'),
        };
    }

    private function sumInputsThenCalculate(KinerjaNode $node, Collection $measurements): ?float
    {
        $resolver = app(\App\Services\Formula\FormulaResolver::class);
        $formula = $resolver->active($node);
        if (in_array($resolver->status($node, $formula), ['DRAFT', 'UNRESOLVED', 'DOCUMENTED', 'DOCUMENTED_ONLY'], true)) return null;
        $key = $resolver->key($node, $formula);
        if (!$this->formulaRegistry->has($key)) return null;
        $rows = [];
        foreach ($measurements as $measurement) {
            $inputs = $measurement->inputs()->pluck('nilai', 'input_key')->all();
            foreach (['pembilang', 'penyebut'] as $column) {
                if (!array_key_exists($column, $inputs) && $measurement->$column !== null) $inputs[$column] = $measurement->$column;
            }
            unset($inputs['realisasi']);
            if ($this->formulaRegistry->calculate($key, new FormulaContext($node, $inputs, formula: $formula))->value === null) return null;
            ksort($inputs);
            $rows[] = $inputs;
        }
        $keys = array_keys($rows[0]);
        foreach ($rows as $row) if (array_keys($row) !== $keys || in_array(null, $row, true)) return null;
        $totals = [];
        foreach ($keys as $inputKey) $totals[$inputKey] = Decimal::sum(array_column($rows, $inputKey), 6);
        return $this->formulaRegistry->calculate($key, new FormulaContext($node, $totals, formula: $formula))->value;
    }

    private function sumRealization(Collection $measurements): ?float
    {
        $valid = $measurements->pluck('realisasi')->filter(fn ($v) => $v !== null && $v !== '');
        return $valid->count() === $measurements->count() ? Decimal::sum($valid->all()) : null;
    }

    private function averageRealization(Collection $measurements): ?float
    {
        $valid = $measurements->pluck('realisasi')->filter(fn ($v) => $v !== null && $v !== '');
        return $valid->count() === $measurements->count() ? Decimal::average($valid->all()) : null;
    }
}
