<?php

namespace Vhar\Quiz\Application\Commands\UpdateQuiz;

use Vhar\Quiz\Application\Mappers\QuizViewMapper;
use Vhar\Quiz\Application\Scopes\QuizEditScope;
use Vhar\Quiz\Application\Views\QuizView;
use Vhar\Quiz\Models\Quiz;

/**
 * Handles quiz update operation.
 */
final readonly class UpdateQuizHandler
{
    /**
     * @param QuizEditScope $quizEditScope Scope for editable quizzes.
     * @param QuizViewMapper $quizViewMapper Mapper for quiz view.
     */
    public function __construct(
        private QuizEditScope $quizEditScope,
        private QuizViewMapper $quizViewMapper,
    ) {
    }

    /**
     * Update existing quiz.
     *
     * @param UpdateQuizCommand $command Update quiz command.
     *
     * @return QuizView Updated quiz view.
     */
    public function handle(
        UpdateQuizCommand $command,
    ): QuizView {
        $builder = Quiz::query();

        $this->quizEditScope->apply(
            $builder,
            $command->user,
        );

        /** @var Quiz $quiz */
        $quiz = $builder->findOrFail(
            $command->quizId,
        );

        $quiz->title = $command->title;
        $quiz->description = $command->description;
        $quiz->quiz_type = $command->quizType;
        $quiz->quiz_duration_range_id = $command->quizDurationRangeId;
        $quiz->age_restriction = $command->ageRestriction;
        $quiz->attempt_limit = $command->attemptLimit;
        $quiz->time_limit = $command->timeLimit;
        $quiz->change_answer = $command->changeAnswer;
        $quiz->scoring_type = $command->scoringType;

        $quiz->save();

        $quiz->loadMissing([
            'user',
            'durationRange',
            'files',
        ]);

        return $this->quizViewMapper->fromModel(
            $quiz,
        );
    }
}