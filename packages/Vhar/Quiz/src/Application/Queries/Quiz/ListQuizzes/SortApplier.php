<?php

namespace Vhar\Quiz\Application\Queries\Quiz\ListQuizzes;

use Illuminate\Database\Eloquent\Builder;

final class SortApplier
{
    private array $allowed = [
        'passed' => 'passed',
        'published_at' => 'published_at',
    ];

    public function apply(
        Builder $builder,
        QuizSort $sort,
    ): Builder {

        foreach ($sort->items as $item) {

            if (!isset($this->allowed[$item->field])) {
                continue;
            }

            $builder->orderBy(
                $this->allowed[$item->field],
                $item->direction,
            );
        }

        return $builder;
    }
}