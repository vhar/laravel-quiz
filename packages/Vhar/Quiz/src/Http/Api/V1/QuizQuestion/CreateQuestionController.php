<?php

namespace Vhar\Quiz\Http\Api\V1\QuizQuestion;

use Vhar\Quiz\Application\Commands\QuizQuestion\CreateQuestion\CreateQuestionCommand;
use Vhar\Quiz\Application\Commands\QuizQuestion\CreateQuestion\CreateQuestionHandler;
use Vhar\Quiz\Enums\QuizQuestionTypeEnum;

/**
 * Class CreateQuestionController
 *
 * Handles client requests to instantiate questions inside specified quizzes.
 *
 * @package Vhar\Quiz\Http\Api\V1\QuizQuestion
 */
final readonly class CreateQuestionController
{
    /**
     * CreateQuestionController constructor.
     *
     * @param CreateQuestionHandler $handler
     */
    public function __construct(
        private CreateQuestionHandler $handler,
    ) {
    }

    /**
     * Create a new question for a specific quiz.
     *
     * @param int $quizId Unique identifier of the target quiz.
     * @param CreateQuestionRequest $request Request details.
     *
     * @return QuizQuestionResource
     */
    public function __invoke(int $quizId, CreateQuestionRequest $request): QuizQuestionResource
    {
        $command = new CreateQuestionCommand(
            quizId: $quizId,
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