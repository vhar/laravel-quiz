<?php

namespace Vhar\Quiz\Application\Queries\Quiz\ListQuizzes;

final readonly class QuizSortItem
{
    public function __construct(
        public string $field,
        public string $direction = 'asc',
    ) {
    }
}