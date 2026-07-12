<?php

namespace Vhar\Quiz\Enums;

enum QuizQuestionTypeEnum: int
{
    case SINGLE = 1;
    case MULTIPLE = 2;

    public function readableOptions(): string
    {
        return match ($this) {
            QuizQuestionTypeEnum::SINGLE => 'Одиночный выбор',
            QuizQuestionTypeEnum::MULTIPLE => 'Множественный выбор',
        };
    }
}
