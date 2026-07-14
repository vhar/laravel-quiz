<?php

namespace Vhar\Quiz\Application\Queries\ListQuizzes;

final readonly class QuizSort
{
    /**
     * @param QuizSortItem[] $items
     */
    public function __construct(
        public array $items = [],
    ) {
    }
}