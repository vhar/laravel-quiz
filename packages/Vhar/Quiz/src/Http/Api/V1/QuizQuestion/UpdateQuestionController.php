<?php

namespace Vhar\Quiz\Http\Api\V1\QuizQuestion;

use Vhar\Quiz\Application\Commands\QuizQuestion\UpdateQuestion\UpdateQuestionCommand;
use Vhar\Quiz\Application\Commands\QuizQuestion\UpdateQuestion\UpdateQuestionHandler;
use Vhar\Quiz\Application\Services\EditAuthorizationResolver;
use Vhar\Quiz\Application\Services\ModelResolver;
use Vhar\Quiz\Enums\QuizQuestionTypeEnum;
use Vhar\Quiz\Models\Quiz;
use Vhar\Quiz\Models\QuizQuestion;

/**
 * Class UpdateQuestionController
 *
 * Handles HTTP requests for updating an existing quiz question scoped under a quiz.
 *
 * @package Vhar\Quiz\Http\Api\V1\QuizQuestion
 */
final readonly class UpdateQuestionController
{
    /**
     * Update an existing quiz question.
     *
     * @param UpdateQuestionRequest $request Validated update request.
     * @param UpdateQuestionHandler $handler Business logic handler.
     * @param ModelResolver $modelResolver Domain entity retriever.
     * @param EditAuthorizationResolver $authResolver Security policy resolver.
     * @param int $quizId Unique identifier of the parent quiz.
     * @param int $questionId Unique identifier of the question.
     *
     * @return QuizQuestionResource Resource representation of the updated question.
     */
    public function __invoke(
        UpdateQuestionRequest $request,
        UpdateQuestionHandler $handler,
        ModelResolver $modelResolver,
        EditAuthorizationResolver $authResolver,
        int $quizId,
        int $questionId
    ): QuizQuestionResource {
        /** @var Quiz $quiz */
        $quiz = $modelResolver->resolve('quiz', $quizId);

        /** @var QuizQuestion $question */
        $question = $modelResolver->resolve('question', $questionId);

        // Authorize using the registered QuizQuestionEditPolicy configuration
        $authResolver->authorize($question, $request->user());

        $command = new UpdateQuestionCommand(
            questionId: $question->id,
            number: $request->integer('number'),
            title: $request->string('title')->toString(),
            type: $request->enum('type', QuizQuestionTypeEnum::class),
            score: $request->integer('score', 0),
            videoUrl: $request->filled('video_url') ? $request->string('video_url')->toString() : null
        );

        $questionView = $handler->handle($command);

        return new QuizQuestionResource($questionView);
    }
}