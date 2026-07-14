<?php

namespace Vhar\Quiz\Application\Scopes;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Vhar\Quiz\Enums\QuizStatusEnum;

final class QuizVisibility
{
    /**
     * Apply quiz visibility rules.
     *
     * Public users can see only quizzes with published or finished status.
     *
     * Authenticated users can additionally see their own quizzes
     * regardless of current status (draft, published, finished, etc.).
     *
     * Example:
     * - Guest:
     *   PUBLISHED + FINISHED
     *
     * - User #10:
     *   PUBLISHED + FINISHED
     *   + all quizzes where user_id = 10
     *
     * @param Builder $builder
     * @param Authenticatable|null $user Current authenticated user.
     *
     * @return Builder
     */
    public function apply(
        Builder $builder,
        ?Authenticatable $user = null,
    ): Builder {
        return $builder->where(function (Builder $query) use ($user) {
            $query->whereIn(
                'status',
                [
                    QuizStatusEnum::PUBLISHED,
                    QuizStatusEnum::FINISHED,
                ]
            );

            if ($user !== null) {
                $query->orWhere(
                    'user_id',
                    $user->getAuthIdentifier()
                );
            }
        });
    }
}