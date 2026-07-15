<?php

namespace Vhar\Quiz\Http\Api\V1\QuizQuestion;

use Vhar\Quiz\Application\Queries\QuizQuestion\GetQuizQuestion\GetQuizQuestionQuery;
use Vhar\Quiz\Application\Queries\QuizQuestion\GetQuizQuestion\GetQuizQuestionHandler;

/**
 * Class GetQuizQuestionController
 *
 * Public endpoint to fetch a single question with its answer options.
 */
final readonly class GetQuizQuestionController
{
    public function __invoke(
        GetQuizQuestionHandler $handler,
        string $quizSlug,
        int $questionNumber
    ): QuizQuestionResource {
        $questionView = $handler->handle(
            new GetQuizQuestionQuery($quizSlug, $questionNumber)
        );

        return new QuizQuestionResource($questionView);
    }
}