<?php

namespace Vhar\Quiz\Enums;

enum QuizTypeEnum: int
{
    case KNOWLEDGE = 1;
    case DIAGNOSTIC = 2;

    public function readableOption(): string
    {
        return match ($this) {
            self::KNOWLEDGE => 'Проверка знаний',
            self::DIAGNOSTIC => 'Диагностика',
        };
    }
}
