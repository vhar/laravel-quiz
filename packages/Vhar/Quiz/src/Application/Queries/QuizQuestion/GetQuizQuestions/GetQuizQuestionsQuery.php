<?php

namespace Vhar\Quiz\Application\Queries\QuizQuestion\GetQuizQuestions;

/**
 * Class GetQuizQuestionsQuery
 *
 * Query DTO for retrieving questions by quiz slug.
 *
 * @package Vhar\Quiz\Application\Queries\QuizQuestion\GetQuizQuestions
 */
final readonly class GetQuizQuestionsQuery
{
    /**
     * GetQuizQuestionsQuery constructor.
     *
     * @param string $quizSlug Unique slug of the quiz.
     */
    public function __construct(
        public string $quizSlug,
    ) {
    }
}