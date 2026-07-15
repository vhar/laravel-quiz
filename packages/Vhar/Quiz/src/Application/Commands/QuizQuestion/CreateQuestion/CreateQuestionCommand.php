<?php

namespace Vhar\Quiz\Application\Commands\QuizQuestion\CreateQuestion;

use Vhar\Quiz\Enums\QuizQuestionTypeEnum;

/**
 * Class CreateQuestionCommand
 *
 * Data Transfer Object containing parameters for creating a new quiz question.
 *
 * @package Vhar\Quiz\Application\Commands\QuizQuestion\CreateQuestion
 */
final readonly class CreateQuestionCommand
{
    /**
     * CreateQuestionCommand constructor.
     *
     * @param int $quizId Parent quiz unique identifier.
     * @param int $number Sequential position within the quiz questions.
     * @param string $title Question text.
     * @param QuizQuestionTypeEnum $type Choice pattern of the question.
     * @param int $score Default score for correctly answering the question.
     * @param string|null $videoUrl Optional URL to instantly attach a video.
     */
    public function __construct(
        public int $quizId,
        public int $number,
        public string $title,
        public QuizQuestionTypeEnum $type,
        public int $score = 0,
        public ?string $videoUrl = null,
    ) {
    }
}