<?php

namespace App\Models\Enums;

enum LeadTag: string
{
    case Signed = 'Signed';
    case Pending = 'Pending';
    case Referred = 'Referred';
}
