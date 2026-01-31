<?php

namespace App\Enums;

enum ApplicationStage: int
{
    case REGISTRATION = 0;
    case QUIZ = 1;
    case FGD = 2;
    case COMPLETED = 3;

    public function label(): string
    {
        return match ($this) {
            self::REGISTRATION => 'Registration',
            self::QUIZ => 'Quiz',
            self::FGD => 'Focus Group Discussion',
            self::COMPLETED => 'Completed',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::REGISTRATION => 'Applicant is filling the registration form',
            self::QUIZ => 'Applicant is taking the quiz',
            self::FGD => 'Applicant is participating in FGD',
            self::COMPLETED => 'Applicant has completed all stages',
        };
    }
}
