<?php

namespace Vhar\Quiz\Http\Api\V1\QuizQuestion;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Vhar\Quiz\Application\Commands\QuizQuestion\DeleteQuestion\DeleteQuestionCommand;
use Vhar\Quiz\Application\Commands\QuizQuestion\DeleteQuestion\DeleteQuestionHandler;

/**
 * Class DeleteQuestionController
 *
 * Handles HTTP requests to delete a quiz question.
 *
 * @package Vhar\Quiz\Http\Api\V1\QuizQuestion
 */
final readonly class DeleteQuestionController
{
    /**
     * DeleteQuestionController constructor.
     *
     * @param DeleteQuestionHandler $handler Execution handler.
     */
    public function __construct(
        private DeleteQuestionHandler $handler,
    ) {
    }

    /**
     * Delete a specific quiz question.
     *
     * @param int $quizId Parent quiz ID.
     * @param int $questionId Target question ID.
     * @param DeleteQuestionRequest $request Request validator.
     *
     * @return JsonResponse Empty response with HTTP 204.
     */
    public function __invoke(
        int $quizId,
        int $questionId,
        DeleteQuestionRequest $request
    ): JsonResponse {
        $command = new DeleteQuestionCommand($questionId);
        $this->handler->handle($command);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}