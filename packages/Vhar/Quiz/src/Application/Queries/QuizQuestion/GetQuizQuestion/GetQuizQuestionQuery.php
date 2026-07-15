<?php

namespace Vhar\Quiz\Application\Queries\QuizQuestion\GetQuizQuestion;

/**
 * Class GetQuizQuestionQuery
 *
 * Query to retrieve a specific question by quiz slug and question number.
 */
final readonly class GetQuizQuestionQuery
{
    public function __construct(
        public string $quizSlug,
        public int $questionNumber,
    ) {
    }
}