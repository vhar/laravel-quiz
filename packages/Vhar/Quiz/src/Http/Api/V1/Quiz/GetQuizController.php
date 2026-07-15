<?php

namespace Vhar\Quiz\Http\Api\V1\Quiz;

use Illuminate\Http\Request;
use Vhar\Quiz\Application\Queries\Quiz\GetQuiz\GetQuizHandler;
use Vhar\Quiz\Application\Queries\Quiz\GetQuiz\GetQuizQuery;
use Vhar\Quiz\Http\Api\V1\Quiz\QuizResource;

final readonly class GetQuizController
{
    public function __invoke(
        Request $request,
        GetQuizHandler $handler,
        string $quizSlug
    ): QuizResource|\Illuminate\Http\JsonResponse {
        return new QuizResource(
            $handler->handle(
                new GetQuizQuery(
                    slug: $quizSlug,
                    user: $request->user(),
                )
            )
        );

    }
}