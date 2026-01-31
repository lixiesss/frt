<?php

namespace App\Enums;

enum FgdCategory: int
{
    case HAXI = 0;
    case IS_AND_CNB = 1;

    public function label(): string
    {
        return match ($this) {
            self::HAXI => 'HAXI',
            self::IS_AND_CNB => 'IS & CnB',
        };
    }
}
