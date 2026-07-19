<?php

namespace Vhar\Quiz\Http\Api\V1\QuizDiagnosticKey;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Vhar\Quiz\Application\Commands\QuizDiagnosticKey\CreateDiagnosticKey\CreateDiagnosticKeyCommand;
use Vhar\Quiz\Application\Commands\QuizDiagnosticKey\CreateDiagnosticKey\CreateDiagnosticKeyHandler;

/**
 * Class CreateDiagnosticKeyController
 *
 * Orchestrates HTTP request coordination to invoke diagnostic key creation logic.
 *
 * @package Vhar\Quiz\Http\Api\V1\QuizDiagnosticKey
 */
final readonly class CreateDiagnosticKeyController
{
    /**
     * CreateDiagnosticKeyController constructor.
     *
     * @param CreateDiagnosticKeyHandler $handler
     */
    public function __construct(
        private CreateDiagnosticKeyHandler $handler,
    ) {
    }

    /**
     * Handle the incoming request to create a diagnostic key.
     *
     * @param int $quizId
     * @param CreateDiagnosticKeyRequest $request
     * @return JsonResponse
     */
    public function __invoke(int $quizId, CreateDiagnosticKeyRequest $request): JsonResponse
    {
        $command = new CreateDiagnosticKeyCommand(
            quizId: $quizId,
            name: $request->validated('name'),
            description: $request->validated('description'),
            sort: $request->validated('sort'),
            levels: $request->validated('levels')
        );

        $view = $this->handler->handle($command);

        return (new CreateDiagnosticKeyResponse($view))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}