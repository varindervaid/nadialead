<?php

namespace App\Models\Enums;

enum NoteStrikeFirst: string
{
    case Connected = 'Connected';
    case Voicemail = 'Voicemail';
    case TestCall = 'Test Call';
    case MissedCall = 'Missed Call';
}
