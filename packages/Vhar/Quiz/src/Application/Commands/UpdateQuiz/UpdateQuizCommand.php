<?php

namespace Vhar\Quiz\Application\Commands\UpdateQuiz;

use Illuminate\Contracts\Auth\Authenticatable;
use Vhar\Quiz\Enums\QuizAgeRestrictionEnum;
use Vhar\Quiz\Enums\QuizScoringTypeEnum;
use Vhar\Quiz\Enums\QuizTypeEnum;

/**
 * Command for updating an existing quiz.
 *
 * Updates only editable quiz fields.
 *
 * The following fields are not handled here:
 * - slug
 * - status
 * - published_at
 * - user_id
 *
 * These fields are managed by separate business operations.
 */
final readonly class UpdateQuizCommand
{
    /**
     * Create update quiz command.
     *
     * @param int $quizId Quiz identifier.
     * @param Authenticatable $user User performing the update.
     * @param string $title Quiz title.
     * @param string|null $description Quiz description.
     * @param QuizTypeEnum $quizType Quiz type.
     * @param int|null $quizDurationRangeId Quiz duration range identifier.
     * @param QuizAgeRestrictionEnum $ageRestriction Age restriction.
     * @param int $attemptLimit Maximum number of attempts.
     * @param int $timeLimit Time limit in seconds.
     * @param bool $changeAnswer Whether answer changing is allowed.
     * @param QuizScoringTypeEnum|null $scoringType Quiz scoring type.
     * @param array|null $quizSettings Additional quiz settings.
     */
    public function __construct(
        public int $quizId,
        public Authenticatable $user,
        public string $title,
        public ?string $description,
        public QuizTypeEnum $quizType,
        public ?int $quizDurationRangeId,
        public QuizAgeRestrictionEnum $ageRestriction,
        public int $attemptLimit,
        public int $timeLimit,
        public bool $changeAnswer,
        public ?QuizScoringTypeEnum $scoringType,
        public ?array $quizSettings,
    ) {
    }
}