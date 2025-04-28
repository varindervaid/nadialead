<?php

namespace App\Models\Enums;

enum LeadRating: string
{
    case VerySatisifed = 'Very satisfied';
    case NeitherSatisifiedNorDissatisfied = 'Neither satisfied nor dissatisfied';
    case SomewhatSatisifed = 'Somewhat satisfied';
    case SomewhatDissatisfied = 'Somewhat dissatisfied';
}
