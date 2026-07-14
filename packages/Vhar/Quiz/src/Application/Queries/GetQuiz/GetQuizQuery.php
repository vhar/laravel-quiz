<?php

namespace Vhar\Quiz\Application\Queries\GetQuiz;

use Illuminate\Contracts\Auth\Authenticatable;
final readonly class GetQuizQuery
{
    /**
     * @param string $slug Quiz slug.
     * @param Authenticatable|null $user Current authenticated user.
     */
    public function __construct(
        public string $slug,
        public ?Authenticatable $user = null,
    ) {
    }
}