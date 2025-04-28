<?php

namespace App\Models\Enums;

enum LeadStatus: string
{
    case LeadRated = 'Lead Rated';
    case WaitingOnIntakeStatus = 'Waiting On Intake Status';
    case Credited = 'Credited';
    case LeadNotRated = 'Lead Not Rated';
}
