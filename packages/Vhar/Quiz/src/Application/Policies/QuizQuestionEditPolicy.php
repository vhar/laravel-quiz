<?php

namespace Vhar\Quiz\Application\Policies;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Vhar\Quiz\Models\QuizQuestion;

/**
 * Class QuizQuestionEditPolicy
 *
 * Validates edit permissions for QuizQuestion models.
 *
 * @package Vhar\Quiz\Application\Policies
 */
final readonly class QuizQuestionEditPolicy
{
    /**
     * Determine if the user can edit the quiz question.
     *
     * @param QuizQuestion $model The quiz question model.
     * @param Authenticatable $user The authenticated user.
     * @return bool
     */
    public function allows(Model $model, Authenticatable $user): bool
    {
        $quiz = $model->quiz;

        if ($quiz === null) {
            return false;
        }

        // Delegate authorization to the owner check of the quiz
        return (int) $quiz->user_id === (int) $user->getAuthIdentifier();
    }
}