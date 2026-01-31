<?php

namespace App\Enums;

enum QuestionType: int
{
    case SERIOUS = 0;
    case TROLL = 1;

    public function label(): string
    {
        return match ($this) {
            self::SERIOUS => 'Serious',
            self::TROLL => 'Troll',
        };
    }
}
