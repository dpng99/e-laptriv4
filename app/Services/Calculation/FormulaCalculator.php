<?php

namespace App\Services\Calculation;

interface FormulaCalculator
{
    public function calculate(FormulaContext $context): CalculationResult;
}
