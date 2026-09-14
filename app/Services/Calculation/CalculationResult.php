<?php

namespace App\Services\Calculation;

final class CalculationResult
{
    public function __construct(
        public readonly ?float $value,
        public readonly array $components = [],
        public readonly array $warnings = [],
    ) {}
}
