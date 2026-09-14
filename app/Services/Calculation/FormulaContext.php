<?php

namespace App\Services\Calculation;

use App\Models\KinerjaNode;
use App\Models\Target;
use App\Models\RumusIndikator;
use Illuminate\Support\Collection;

final class FormulaContext
{
    public function __construct(
        public readonly KinerjaNode $node,
        public readonly array $rawInputs, // Key-value array of raw inputs (e.g., ['pembilang' => 10, 'penyebut' => 20])
        public readonly ?Target $target = null,
        public readonly Collection $childrenMeasurements = new Collection(), // For rollup/aggregations
        public readonly ?RumusIndikator $formula = null,
    ) {}
}
