<?php

namespace Vhar\Quiz\Http\Api\V1\Quiz;

use Vhar\Quiz\Application\Commands\CreateQuiz\CreateQuizCommand;
use Vhar\Quiz\Application\Commands\CreateQuiz\CreateQuizHandler;
use Vhar\Quiz\Enums\QuizAgeRestrictionEnum;
use Vhar\Quiz\Enums\QuizScoringTypeEnum;
use Vhar\Quiz\Enums\QuizTypeEnum;
use Vhar\Quiz\Http\Api\V1\Quiz\CreateQuizRequest;
use Vhar\Quiz\Http\Api\V1\Quiz\QuizResource;

final readonly class CreateQuizController
{
    /**
     * Create a new quiz.
     *
     * @param CreateQuizRequest $request Validated quiz creation request.
     * @param CreateQuizHandler $handler Quiz creation handler.
     *
     * @return QuizResource Created quiz resource.
     */
    public function __invoke(
        CreateQuizRequest $request,
        CreateQuizHandler $handler,
    ): QuizResource {
        $data = [
            'userId' => $request->user()->id,

            'title' => $request->string('title')->toString(),
            'slug' => $request->string('slug')->toString(),
            'type' => $request->enum('quiz_type', QuizTypeEnum::class),

            'description' => $request->input('description'),
        ];

        if ($request->has('quiz_duration_range_id')) {
            $data['quizDurationRangeId'] = $request->integer('quiz_duration_range_id');
        }

        if ($request->has('age_restriction')) {
            $data['ageRestriction'] = $request->enum(
                'age_restriction',
                QuizAgeRestrictionEnum::class
            );
        }

        if ($request->has('attempt_limit')) {
            $data['attemptLimit'] = $request->integer('attempt_limit');
        }

        if ($request->has('time_limit')) {
            $data['timeLimit'] = $request->integer('time_limit');
        }

        if ($request->has('change_answer')) {
            $data['changeAnswer'] = $request->boolean('change_answer');
        }

        if ($request->has('scoring_type')) {
            $data['scoringType'] = $request->enum(
                'scoring_type',
                QuizScoringTypeEnum::class
            );
        }

        $quiz = $handler->handle(
            new CreateQuizCommand(...$data)
        );

        return new QuizResource($quiz);
    }
}