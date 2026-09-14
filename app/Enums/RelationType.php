<?php

namespace App\Enums;

enum RelationType: string
{
    case CASCADING = 'CASCADING';
    case FORMULA_COMPONENT = 'FORMULA_COMPONENT';
    case CONTRIBUTION = 'CONTRIBUTION';
    case SAME_INDICATOR = 'SAME_INDICATOR';
    case ORG_AGGREGATION = 'ORG_AGGREGATION';
    case REFERENCE = 'REFERENCE';
    case STRUCTURAL = 'STRUCTURAL';
}
