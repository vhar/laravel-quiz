<?php

namespace Vhar\Quiz\Application\Queries\Quiz\ListQuizzes;

final class SortParser
{
    public function parse(?string $sort): QuizSort
    {
        if (!$sort) {
            return new QuizSort();
        }

        $items = [];

        foreach (explode(',', $sort) as $item) {
            $items[] = new QuizSortItem(
                field: ltrim($item, '-'),
                direction: str_starts_with($item, '-')
                ? 'desc'
                : 'asc',
            );
        }

        return new QuizSort($items);
    }
}