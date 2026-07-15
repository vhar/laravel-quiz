<?php

namespace Vhar\Quiz\Application\Commands\Quiz\CreateQuiz;

use Vhar\Quiz\Enums\QuizAgeRestrictionEnum;
use Vhar\Quiz\Enums\QuizScoringTypeEnum;
use Vhar\Quiz\Enums\QuizTypeEnum;

final readonly class CreateQuizCommand
{
    public function __construct(
        public int $userId,
        public string $title,
        public string $slug,
        public QuizTypeEnum $type,
        public ?string $description = null,
        public ?int $quizDurationRangeId = null,
        public QuizAgeRestrictionEnum $ageRestriction = QuizAgeRestrictionEnum::ZERO_PLUS,
        public int $attemptLimit = 0,
        public int $timeLimit = 0,
        public ?QuizScoringTypeEnum $scoringType = null,
        public bool $changeAnswer = false,
    ) {
    }
}
