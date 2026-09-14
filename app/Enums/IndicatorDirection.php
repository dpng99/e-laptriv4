<?php

namespace App\Enums;

enum IndicatorDirection: string
{
    case HIGHER_IS_BETTER = 'HIGHER_IS_BETTER';
    case LOWER_IS_BETTER = 'LOWER_IS_BETTER';
    case EXACT = 'EXACT';
    case RANGE = 'RANGE';
    case EXTERNAL = 'EXTERNAL';
}
