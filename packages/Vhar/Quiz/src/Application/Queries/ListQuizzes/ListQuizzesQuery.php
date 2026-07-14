<?php

namespace Vhar\Quiz\Application\Queries\ListQuizzes;

use Illuminate\Contracts\Auth\Authenticatable;

final readonly class ListQuizzesQuery
{
    public function __construct(
        public QuizFilters $filters = new QuizFilters(),
        public QuizSort $sort = new QuizSort(),

        public ?Authenticatable $user = null,

        public int $page = 1,
        public int $perPage = 15,
    ) {
    }
}