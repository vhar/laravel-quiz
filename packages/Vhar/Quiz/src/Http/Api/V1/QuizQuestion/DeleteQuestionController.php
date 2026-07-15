<?php

namespace Vhar\Quiz\Http\Api\V1\QuizQuestion;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Vhar\Quiz\Application\Commands\QuizQuestion\DeleteQuestion\DeleteQuestionCommand;
use Vhar\Quiz\Application\Commands\QuizQuestion\DeleteQuestion\DeleteQuestionHandler;
use Vhar\Quiz\Application\Services\EditAuthorizationResolver;
use Vhar\Quiz\Application\Services\ModelResolver;
use Vhar\Quiz\Models\Quiz;
use Vhar\Quiz\Models\QuizQuestion;

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
     * Delete a specific quiz question.
     *
     * @param DeleteQuestionRequest $request Request validator.
     * @param DeleteQuestionHandler $handler Execution handler.
     * @param ModelResolver $modelResolver Domain entity retriever.
     * @param EditAuthorizationResolver $authResolver Security policy resolver.
     * @param int $quizId Parent quiz ID.
     * @param int $questionId Target question ID.
     *
     * @return JsonResponse Empty response with HTTP 204.
     */
    public function __invoke(
        DeleteQuestionRequest $request,
        DeleteQuestionHandler $handler,
        ModelResolver $modelResolver,
        EditAuthorizationResolver $authResolver,
        int $quizId,
        int $questionId
    ): JsonResponse {
        /** @var Quiz $quiz */
        $quiz = $modelResolver->resolve('quiz', $quizId);

        /** @var QuizQuestion $question */
        $question = $modelResolver->resolve('question', $questionId);

        // Authorize edit rights (which logically covers deletion as well)
        $authResolver->authorize($question, $request->user());

        $command = new DeleteQuestionCommand($question->id);
        $handler->handle($command);

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}