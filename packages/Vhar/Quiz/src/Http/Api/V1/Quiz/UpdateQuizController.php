<?php

namespace Vhar\Quiz\Http\Api\V1\Quiz;

use Illuminate\Http\JsonResponse;
use Vhar\Quiz\Application\Commands\UpdateQuiz\UpdateQuizCommand;
use Vhar\Quiz\Application\Commands\UpdateQuiz\UpdateQuizHandler;
use Vhar\Quiz\Application\Services\EditAuthorizationResolver;
use Vhar\Quiz\Application\Services\ModelResolver;
use Vhar\Quiz\Enums\QuizAgeRestrictionEnum;
use Vhar\Quiz\Enums\QuizScoringTypeEnum;
use Vhar\Quiz\Enums\QuizTypeEnum;

/**
 * Handles quiz update requests.
 */
final readonly class UpdateQuizController
{
    /**
     * Update an existing quiz.
     *
     * Only fields related to quiz content and settings are updated.
     * Status, slug and publication date are managed by separate commands.
     *
     * @param UpdateQuizRequest $request Validated quiz update request.
     * @param UpdateQuizHandler $handler Quiz update handler.
     * @param ModelResolver $modelResolver Target model resolver.
     * @param EditAuthorizationResolver $authorizationResolver Model edit authorization resolver.
     *
     * @return QuizResource|JsonResponse Updated quiz resource or error response.
     */
    public function __invoke(
        UpdateQuizRequest $request,
        UpdateQuizHandler $handler,
        ModelResolver $modelResolver,
        EditAuthorizationResolver $authorizationResolver,
        int $quizId,
    ): QuizResource|JsonResponse {
        $quiz = $modelResolver->resolve(
            'quiz',
            $quizId,
        );

        $authorizationResolver->authorize(
            $quiz,
            $request->user(),
        );

        $quiz = $handler->handle(
            new UpdateQuizCommand(
                quizId: $quizId,
                user: $request->user(),

                title: $request->string('title')->toString(),

                description: $request->input('description'),

                quizType: $request->enum(
                    'quiz_type',
                    QuizTypeEnum::class
                ),

                quizDurationRangeId: $request->input(
                    'quiz_duration_range_id'
                ),

                ageRestriction: $request->enum(
                    'age_restriction',
                    QuizAgeRestrictionEnum::class
                ),

                attemptLimit: $request->integer(
                    'attempt_limit'
                ),

                timeLimit: $request->integer(
                    'time_limit'
                ),

                changeAnswer: $request->boolean(
                    'change_answer'
                ),

                scoringType: $request->enum(
                    'scoring_type',
                    QuizScoringTypeEnum::class
                ),

                quizSettings: $request->input(
                    'quiz_settings'
                ),
            )
        );

        return new QuizResource($quiz);
    }
}