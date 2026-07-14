<?php

namespace Vhar\Quiz\Http\Api\V1\Quiz;

use Illuminate\Http\Request;
use Vhar\Quiz\Application\Queries\GetQuiz\GetQuizHandler;
use Vhar\Quiz\Application\Queries\GetQuiz\GetQuizQuery;
use Vhar\Quiz\Http\Api\V1\Quiz\QuizResource;

final readonly class GetQuizController
{
    public function __invoke(
        Request $request,
        GetQuizHandler $handler,
        string $slug
    ): QuizResource|\Illuminate\Http\JsonResponse {
        return new QuizResource(
            $handler->handle(
                new GetQuizQuery(
                    slug: $slug,
                    user: $request->user(),
                )
            )
        );

    }
}