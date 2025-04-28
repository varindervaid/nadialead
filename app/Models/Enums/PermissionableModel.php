<?php

namespace App\Models\Enums;

use App\Models\Lead;
use App\Models\LeadColor;
use App\Models\User;

enum PermissionableModel : string
{
    case User = User::class;
    case Lead = Lead::class;
    case LeadColor = LeadColor::class;
}
