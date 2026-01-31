<?php

namespace App\Enums;

enum Major: string
{
    case IF = 'if';
    case SIB = 'sib';
    case DSA = 'dsa';

    public function label(): string
    {
        return match ($this) {
            self::IF => 'Informatika',
            self::SIB => 'Sistem Informasi Bisnis',
            self::DSA => 'Data Science and Analytics',
        };
    }
}
