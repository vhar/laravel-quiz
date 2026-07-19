<?php

namespace Vhar\Quiz\Application\Policies;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Vhar\Quiz\Models\QuizDiagnosticKey;

/**
 * Class QuizDiagnosticKeyEditPolicy
 *
 * Validates edit permissions for QuizDiagnosticKey models.
 *
 * @package Vhar\Quiz\Application\Policies
 */
final readonly class QuizDiagnosticKeyEditPolicy
{
    /**
     * Determine if the user can edit the quiz diagnostic key.
     *
     * @param QuizDiagnosticKey $model The quiz diagnostic key model.
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