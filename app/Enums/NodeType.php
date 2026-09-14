<?php

namespace App\Enums;

enum NodeType: string
{
    case SS = 'SS';
    case IKSS = 'IKSS';
    case SP = 'SP';
    case IKP = 'IKP';
    case SK = 'SK';
    case IKK = 'IKK';

    public function isIndicator(): bool
    {
        return in_array($this, [self::IKSS, self::IKP, self::IKK], true);
    }
}
