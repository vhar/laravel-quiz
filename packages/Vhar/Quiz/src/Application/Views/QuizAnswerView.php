<?php

namespace Vhar\Quiz\Application\Views;

use Vhar\Quiz\Application\Data\FileData;

/**
 * Class QuizAnswerView
 *
 * Read-only Data Transfer Object representing a quiz question answer choice.
 *
 * @package Vhar\Quiz\Application\Views
 */
final readonly class QuizAnswerView
{
    /**
     * QuizAnswerView constructor.
     *
     * @param int $id
     * @param int $questionId
     * @param string $title
     * @param bool|null $isCorrect Hidden in public API to prevent cheating, present in admin context.
     * @param FileData|null $file Optional attached image or document for the answer option.
     */
    public function __construct(
        public int $id,
        public int $questionId,
        public string $title,
        public ?bool $isCorrect = null,
        public ?FileData $file = null,
    ) {
    }
}