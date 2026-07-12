<?php

namespace Vhar\Quiz\Enums;

enum QuizStatusEnum: int
{
    case DRAFT = 1;
    case MODERATION = 2;
    case PUBLISHED = 3;
    case NOT_PUBLISHED = 4;
    case FINISHED = 5;

    public function readableOptions(): string
    {
        return match ($this) {
            QuizStatusEnum::DRAFT => 'Черновик',
            QuizStatusEnum::MODERATION => 'На проверке',
            QuizStatusEnum::PUBLISHED => 'Опубликован',
            QuizStatusEnum::NOT_PUBLISHED => 'Отклонен',
            QuizStatusEnum::FINISHED => 'Завершен',
        };
    }
}
