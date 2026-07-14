<?php

namespace Vhar\Quiz\Application\Scopes;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;

/**
 * Scope for restricting quiz editing.
 *
 * Applies conditions that limit the query to quizzes the current
 * user is allowed to edit.
 *
 * Currently only quiz authors can edit their own quizzes.
 * This scope can be extended in the future to support moderators
 * and other privileged roles.
 */
final readonly class QuizEditScope
{
    /**
     * Apply edit restrictions to the query.
     *
     * @param Builder $builder Quiz query builder.
     * @param Authenticatable $user Authenticated user.
     *
     * @return Builder
     */
    public function apply(
        Builder $builder,
        Authenticatable $user,
    ): Builder {
        return $builder->where(
            'user_id',
            $user->getAuthIdentifier()
        );
    }
}