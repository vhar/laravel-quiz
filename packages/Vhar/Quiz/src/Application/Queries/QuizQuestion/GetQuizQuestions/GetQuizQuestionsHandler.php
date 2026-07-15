<?php

namespace Vhar\Quiz\Application\Queries\QuizQuestion\GetQuizQuestions;

use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vhar\Quiz\Application\Mappers\QuizQuestionViewMapper;
use Vhar\Quiz\Models\Quiz;

/**
 * Class GetQuizQuestionsHandler
 *
 * Handles fetching all questions belonging to a quiz identified by slug.
 *
 * @package Vhar\Quiz\Application\Queries\QuizQuestion\GetQuizQuestions
 */
final readonly class GetQuizQuestionsHandler
{
    /**
     * GetQuizQuestionsHandler constructor.
     *
     * @param QuizQuestionViewMapper $mapper
     */
    public function __construct(
        private QuizQuestionViewMapper $mapper,
    ) {
    }

    /**
     * Execute query to get questions.
     *
     * @param GetQuizQuestionsQuery $query
     * @return Collection<int, \Vhar\Quiz\Application\Views\QuizQuestionView>
     */
    public function handle(GetQuizQuestionsQuery $query): Collection
    {
        /** @var Quiz|null $quiz */
        $quiz = Quiz::where('slug', $query->quizSlug)->first();

        if ($quiz === null) {
            throw new NotFoundHttpException('Quiz not found.');
        }

        // Get the Eloquent Collection of models
        $questions = $quiz->questions()
            ->orderBy('number')
            ->with(['files', 'videos'])
            ->get();

        // Transform the collection from models to read-view DTOs (converts Eloquent Col. to Support Col.)
        return $questions->map(
            fn($question) => $this->mapper->fromModel($question)
        );
    }
}