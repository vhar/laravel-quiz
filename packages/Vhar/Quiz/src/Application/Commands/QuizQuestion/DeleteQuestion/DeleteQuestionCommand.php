<?php

namespace Vhar\Quiz\Application\Commands\QuizQuestion\DeleteQuestion;

/**
 * Class DeleteQuestionCommand
 *
 * Data Transfer Object containing the identifier of the question to delete.
 *
 * @package Vhar\Quiz\Application\Commands\QuizQuestion\DeleteQuestion
 */
final readonly class DeleteQuestionCommand
{
    /**
     * DeleteQuestionCommand constructor.
     *
     * @param int $questionId Unique identifier of the question.
     */
    public function __construct(
        public int $questionId,
    ) {
    }
}