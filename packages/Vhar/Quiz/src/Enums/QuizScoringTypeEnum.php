<?php

namespace Vhar\Quiz\Enums;

enum QuizScoringTypeEnum: int
{
    case SCORE = 1;
    case TRUE_FALSE = 2;

    public function readableOption(): string
    {
        return match ($this) {
            self::SCORE => 'На очки',
            self::TRUE_FALSE => 'Верный/Не верный',
        };
    }
}
