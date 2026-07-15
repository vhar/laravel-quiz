<?php

namespace Vhar\Quiz\Application\Queries\Quiz\ListQuizzes;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Vhar\Quiz\Application\Mappers\QuizViewMapper;
use Vhar\Quiz\Application\Scopes\QuizVisibility;
use Vhar\Quiz\Models\Quiz;

final readonly class ListQuizzesHandler
{
    public function __construct(
        private QuizViewMapper $quizViewMapper,
        private QuizFilterApplier $quizFilterApplier,
        private SortApplier $sortApplier,
        private QuizVisibility $quizVisibility,
    ) {
    }

    public function handle(
        ListQuizzesQuery $query
    ): LengthAwarePaginator {
        $builder = Quiz::query()
            ->with([
                'user',
                'files',
                'durationRange',
            ]);

        $this->quizVisibility->apply(
            $builder,
            $query->user
        );

        $this->quizFilterApplier->apply(
            $builder,
            $query->filters,
        );

        $this->sortApplier->apply(
            $builder,
            $query->sort,
        );

        $quizzes = $builder->paginate(
            perPage: $query->perPage,
            page: $query->page,
        );

        $quizzes->getCollection()
            ->transform(
                fn(Quiz $quiz) =>
                $this->quizViewMapper->fromModel($quiz)
            );

        return $quizzes;
    }
}