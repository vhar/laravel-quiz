<?php

namespace Vhar\Quiz\Http\Api\V1\QuizQuestion;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Vhar\Quiz\Application\Queries\QuizQuestion\GetQuizQuestions\GetQuizQuestionsQuery;
use Vhar\Quiz\Application\Queries\QuizQuestion\GetQuizQuestions\GetQuizQuestionsHandler;

/**
 * Class GetQuizQuestionsController
 *
 * Public endpoint to list all questions of a quiz.
 *
 * @package Vhar\Quiz\Http\Api\V1\QuizQuestion
 */
final readonly class GetQuizQuestionsController
{
    /**
     * List questions for a quiz.
     *
     * @param GetQuizQuestionsHandler $handler
     * @param string $quizSlug
     * @return AnonymousResourceCollection
     */
    public function __invoke(
        GetQuizQuestionsHandler $handler,
        string $quizSlug
    ): AnonymousResourceCollection {
        $questions = $handler->handle(
            new GetQuizQuestionsQuery($quizSlug)
        );

        return QuizQuestionResource::collection($questions);
    }
}