<?php

namespace Vhar\Quiz\Application\Queries\Quiz\ListQuizzes;

use Vhar\Quiz\Enums\QuizAgeRestrictionEnum;
use Vhar\Quiz\Enums\QuizTypeEnum;
use Vhar\Quiz\Enums\QuizAvailabilityEnum;

final readonly class QuizFilters
{
    /**
     * @param QuizTypeEnum[] $quizTypes
     * @param QuizAgeRestrictionEnum[] $ageRestrictions
     * @param int[] $durationRangeIds
     * @param int[] $tagIds
     */
    public function __construct(
        public array $quizTypes = [],
        public array $ageRestrictions = [],
        public array $durationRangeIds = [],

        public ?bool $hasTimeLimit = null,
        public ?bool $hasAttemptLimit = null,

        public array $tagIds = [],
        public ?QuizAvailabilityEnum $availability = null,

    ) {
    }
}