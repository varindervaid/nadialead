<?php

namespace App\Models\Enums;

enum UserStatus : int
{
    case Active = 1;
    case Block = 2;

    public function label() : array
    {
        return match ($this) {
            self::Active => [self::Active->name, 'green'],
            self::Block => [self::Block->name, 'red'],
        };
    }
}
