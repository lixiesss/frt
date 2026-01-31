<?php

namespace App\Enums;

enum TestType: int
{
    case PRETEST = 0;
    case POSTTEST = 1;

    public function label(): string
    {
        return match ($this) {
            self::PRETEST => 'Pre-Test',
            self::POSTTEST => 'Post-Test',
        };
    }
}
