<?php

namespace Vhar\Quiz\Http\Api\V1\QuizDiagnosticKey;

use Illuminate\Http\Response;
use Vhar\Quiz\Application\Commands\QuizDiagnosticKey\DeleteDiagnosticKey\DeleteDiagnosticKeyCommand;
use Vhar\Quiz\Application\Commands\QuizDiagnosticKey\DeleteDiagnosticKey\DeleteDiagnosticKeyHandler;

/**
 * Class DeleteDiagnosticKeyController
 *
 * Orchestrates HTTP request coordination to execute diagnostic key deletion routines.
 *
 * @package Vhar\Quiz\Http\Api\V1\QuizDiagnosticKey
 */
final readonly class DeleteDiagnosticKeyController
{
    /**
     * DeleteDiagnosticKeyController constructor.
     *
     * @param DeleteDiagnosticKeyHandler $handler
     */
    public function __construct(
        private DeleteDiagnosticKeyHandler $handler,
    ) {
    }

    /**
     * Handle the incoming request to delete a specific diagnostic key.
     *
     * @param int $quizId
     * @param int $keyId
     * @param DeleteDiagnosticKeyRequest $request
     * @return Response
     */
    public function __invoke(int $quizId, int $keyId, DeleteDiagnosticKeyRequest $request): Response
    {
        $command = new DeleteDiagnosticKeyCommand(
            id: $keyId,
            quizId: $quizId
        );

        $this->handler->handle($command);

        return response()->noContent();
    }
}