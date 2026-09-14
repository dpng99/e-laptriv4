<?php

namespace App\Enums;

enum TargetStatus: string
{
    case DRAFT = 'DRAFT';
    case OFFICIAL = 'OFFICIAL';
    case CONFLICT = 'CONFLICT';
    case NOT_SET = 'NOT_SET';
}
