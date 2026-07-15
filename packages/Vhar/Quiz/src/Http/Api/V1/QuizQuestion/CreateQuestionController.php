<?php

namespace Vhar\Quiz\Http\Api\V1\QuizQuestion;

use Vhar\Quiz\Application\Commands\QuizQuestion\CreateQuestion\CreateQuestionCommand;
use Vhar\Quiz\Application\Commands\QuizQuestion\CreateQuestion\CreateQuestionHandler;
use Vhar\Quiz\Application\Services\EditAuthorizationResolver;
use Vhar\Quiz\Application\Services\ModelResolver;
use Vhar\Quiz\Enums\QuizQuestionTypeEnum;
use Vhar\Quiz\Models\Quiz;

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
     * Create a new question for a specific quiz.
     *
     * @param CreateQuestionRequest $request Request details.
     * @param CreateQuestionHandler $handler Execution handler.
     * @param ModelResolver $modelResolver Domain entity retriever.
     * @param EditAuthorizationResolver $authResolver Security policy resolver.
     * @param int $quizId Unique identifier of the target quiz.
     *
     * @return QuizQuestionResource
     */
    public function __invoke(
        CreateQuestionRequest $request,
        CreateQuestionHandler $handler,
        ModelResolver $modelResolver,
        EditAuthorizationResolver $authResolver,
        int $quizId
    ): QuizQuestionResource {
        /** @var Quiz $quiz */
        $quiz = $modelResolver->resolve('quiz', $quizId);

        // Authorize the current user to edit the specified quiz, passing the authenticated user
        $authResolver->authorize($quiz, $request->user());

        $command = new CreateQuestionCommand(
            quizId: $quiz->id,
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