<?php

namespace Vhar\Quiz\Http\Api\V1\QuizDiagnosticKey;

use Illuminate\Http\JsonResponse;
use Vhar\Quiz\Application\Queries\QuizDiagnosticKey\GetDiagnosticKeys\GetDiagnosticKeysHandler;
use Vhar\Quiz\Application\Queries\QuizDiagnosticKey\GetDiagnosticKeys\GetDiagnosticKeysQuery;
use Vhar\Quiz\Models\Quiz;

/**
 * Class GetDiagnosticKeysController
 *
 * Handles the HTTP orchestration for retrieving a quiz's diagnostic keys structure by slug.
 *
 * @package Vhar\Quiz\Http\Api\V1\QuizDiagnosticKey
 */
final class GetDiagnosticKeysController
{
    /**
     * GetDiagnosticKeysController constructor.
     *
     * @param GetDiagnosticKeysHandler $handler Business processor for the reading pipeline.
     */
    public function __construct(
        private GetDiagnosticKeysHandler $handler
    ) {
    }

    /**
     * Retrieve diagnostic keys for the specified quiz identified by slug.
     *
     * @param string $quizSlug Path parameter referencing the parent quiz slug.
     * @return JsonResponse Emitted JSON structure containing filtered read-models.
     */
    public function __invoke(string $quizSlug): JsonResponse
    {
        /** @var Quiz $quiz */
        $quiz = Quiz::query()
            ->where('slug', $quizSlug)
            ->firstOrFail();

        $data = $this->handler->handle(
            new GetDiagnosticKeysQuery($quiz->id)
        );

        return new JsonResponse([
            'data' => $data,
        ]);
    }
}