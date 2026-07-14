<?php

namespace Vhar\Quiz\Application\Policies;

use Illuminate\Contracts\Auth\Authenticatable;
use Vhar\Quiz\Models\Quiz;

/**
 * Authorization rules for quiz editing.
 *
 * Defines whether a user is allowed to modify
 * an existing quiz.
 *
 * Can be extended in the future to support
 * moderators and other privileged roles.
 */
final readonly class QuizEditPolicy
{
    /**
     * Determine whether user can edit quiz.
     *
     * @param Quiz $quiz Quiz model.
     * @param Authenticatable $user Authenticated user.
     *
     * @return bool
     */
    public function allows(
        Quiz $quiz,
        Authenticatable $user,
    ): bool {
        return (int) $quiz->user_id === (int) $user->getAuthIdentifier();
    }
}