<?php

namespace Vhar\Quiz\Http\Api\V1\QuizDiagnosticKey;

use Illuminate\Http\JsonResponse;
use Vhar\Quiz\Application\Commands\QuizDiagnosticKey\UpdateDiagnosticKey\UpdateDiagnosticKeyCommand;
use Vhar\Quiz\Application\Commands\QuizDiagnosticKey\UpdateDiagnosticKey\UpdateDiagnosticKeyHandler;

/**
 * Class UpdateDiagnosticKeyController
 *
 * Orchestrates HTTP request coordination to invoke diagnostic key modification logic.
 *
 * @package Vhar\Quiz\Http\Api\V1\QuizDiagnosticKey
 */
final readonly class UpdateDiagnosticKeyController
{
    /**
     * UpdateDiagnosticKeyController constructor.
     *
     * @param UpdateDiagnosticKeyHandler $handler
     */
    public function __construct(
        private UpdateDiagnosticKeyHandler $handler,
    ) {
    }

    /**
     * Handle the incoming request to update a diagnostic key.
     *
     * @param int $quizId
     * @param int $keyId
     * @param UpdateDiagnosticKeyRequest $request
     * @return JsonResponse
     */
    public function __invoke(int $quizId, int $keyId, UpdateDiagnosticKeyRequest $request): JsonResponse
    {
        $command = new UpdateDiagnosticKeyCommand(
            id: $keyId,
            quizId: $quizId,
            name: $request->validated('name'),
            description: $request->validated('description'),
            sort: $request->validated('sort'),
            levels: $request->validated('levels')
        );

        $view = $this->handler->handle($command);

        return (new UpdateDiagnosticKeyResponse($view))->response();
    }
}