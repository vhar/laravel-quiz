<?php

namespace Vhar\Quiz\Application\Queries\Quiz\GetQuiz;

use Vhar\Quiz\Application\Mappers\QuizViewMapper;
use Vhar\Quiz\Application\Scopes\QuizVisibility;
use Vhar\Quiz\Application\Views\QuizView;
use Vhar\Quiz\Models\Quiz;

final class GetQuizHandler
{
    public function __construct(
        private QuizViewMapper $quizViewMapper,
        private QuizVisibility $quizVisibility,
    ) {
    }

    public function handle(GetQuizQuery $query): QuizView
    {
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

        $quiz = $builder
            ->where('slug', $query->slug)
            ->firstOrFail();

        return $this->quizViewMapper->fromModel($quiz);
    }
}