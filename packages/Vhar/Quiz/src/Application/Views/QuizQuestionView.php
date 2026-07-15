<?php

namespace Vhar\Quiz\Application\Views;

use Vhar\Quiz\Application\Data\FileData;
use Vhar\Quiz\Application\Data\OptionData;
use Vhar\Quiz\Application\Data\VideoData;

/**
 * Class QuizQuestionView
 *
 * Immutable Read-Model representing a quiz question.
 *
 * @package Vhar\Quiz\Application\Views
 */
final readonly class QuizQuestionView
{
    /**
     * QuizQuestionView constructor.
     *
     * @param int $id Unique identifier of the question.
     * @param int $quizId ID of the parent quiz.
     * @param int $number Sequential position of the question in the quiz.
     * @param string $title The question text.
     * @param OptionData $type Formatted question type (single/multiple choice).
     * @param int $score Points awarded for a correct answer.
     * @param FileData|null $file Single attached image/file metadata.
     * @param VideoData|null $video Single attached external video metadata.
     */
    public function __construct(
        public int $id,
        public int $quizId,
        public int $number,
        public string $title,
        public OptionData $type,
        public int $score,
        public ?FileData $file = null,
        public ?VideoData $video = null,
    ) {
    }
}