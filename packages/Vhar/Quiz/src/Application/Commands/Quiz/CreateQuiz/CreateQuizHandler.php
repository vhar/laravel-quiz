<?php

namespace Vhar\Quiz\Application\Commands\Quiz\CreateQuiz;

use Vhar\Quiz\Application\Mappers\QuizViewMapper;
use Vhar\Quiz\Application\Views\QuizView;
use Vhar\Quiz\Enums\QuizStatusEnum;
use Vhar\Quiz\Models\Quiz;

final readonly class CreateQuizHandler
{
    public function __construct(
        private QuizViewMapper $quizViewMapper,
    ) {
    }

    public function handle(CreateQuizCommand $command): QuizView
    {
        $quiz = Quiz::create([
            'user_id' => $command->userId,
            'title' => $command->title,
            'slug' => $command->slug,
            'quiz_type' => $command->type,
            'description' => $command->description,
            'quiz_duration_range_id' => $command->quizDurationRangeId,
            'age_restriction' => $command->ageRestriction,
            'attempt_limit' => $command->attemptLimit,
            'time_limit' => $command->timeLimit,
            'change_answer' => $command->changeAnswer,
            'scoring_type' => $command->scoringType,
            'status' => QuizStatusEnum::DRAFT,
        ]);

        $quiz = $quiz->fresh();

        $quiz->load([
            'files',
            'durationRange',
        ]);

        return $this->quizViewMapper->fromModel($quiz);
    }
}