<?php

namespace Vhar\Quiz\Application\Commands\QuizQuestion\UpdateQuestion;

use Vhar\Quiz\Enums\QuizQuestionTypeEnum;

/**
 * Class UpdateQuestionCommand
 *
 * Data Transfer Object for updating an existing quiz question.
 *
 * @package Vhar\Quiz\Application\Commands\QuizQuestion\UpdateQuestion
 */
final readonly class UpdateQuestionCommand
{
    /**
     * UpdateQuestionCommand constructor.
     *
     * @param int $questionId Unique identifier of the question to update.
     * @param int $number Sequential number of the question within the quiz.
     * @param string $title The question text.
     * @param QuizQuestionTypeEnum $type Type of the question (single or multiple choice).
     * @param int $score Points awarded for the correct answer.
     * @param string|null $videoUrl Optional URL to attach or update the video.
     */
    public function __construct(
        public int $questionId,
        public int $number,
        public string $title,
        public QuizQuestionTypeEnum $type,
        public int $score = 0,
        public ?string $videoUrl = null,
    ) {
    }
}