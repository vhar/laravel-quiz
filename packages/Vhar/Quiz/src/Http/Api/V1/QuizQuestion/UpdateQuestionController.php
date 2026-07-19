<?php

namespace Vhar\Quiz\Http\Api\V1\QuizQuestion;

use Vhar\Quiz\Application\Commands\QuizQuestion\UpdateQuestion\UpdateQuestionCommand;
use Vhar\Quiz\Application\Commands\QuizQuestion\UpdateQuestion\UpdateQuestionHandler;
use Vhar\Quiz\Enums\QuizQuestionTypeEnum;

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
     * UpdateQuestionController constructor.
     *
     * @param UpdateQuestionHandler $handler Business logic handler.
     */
    public function __construct(
        private UpdateQuestionHandler $handler,
    ) {
    }

    /**
     * Update an existing quiz question.
     *
     * @param int $quizId Unique identifier of the parent quiz.
     * @param int $questionId Unique identifier of the question.
     * @param UpdateQuestionRequest $request Validated update request.
     *
     * @return QuizQuestionResource Resource representation of the updated question.
     */
    public function __invoke(
        int $quizId,
        int $questionId,
        UpdateQuestionRequest $request
    ): QuizQuestionResource {
        $command = new UpdateQuestionCommand(
            questionId: $questionId,
            number: $request->integer('number'),
            title: $request->string('title')->toString(),
            type: $request->enum('type', QuizQuestionTypeEnum::class),
            score: $request->integer('score', 0),
            videoUrl: $request->filled('video_url') ? $request->string('video_url')->toString() : null
        );

        $questionView = $this->handler->handle($command);

        return new QuizQuestionResource($questionView);
    }
}