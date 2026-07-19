<?php

namespace Vhar\Quiz\Application\Views;

/**
 * Class QuizDiagnosticKeyLevelView
 *
 * Read-model representation of a quiz diagnostic key level.
 *
 * @package Vhar\Quiz\Application\Views
 */
final readonly class QuizDiagnosticKeyLevelView
{
    /**
     * QuizDiagnosticKeyLevelView constructor.
     *
     * @param int $id
     * @param int $quizDiagnosticKeyId
     * @param string $name
     * @param string $description
     * @param int $minValue
     * @param int $maxValue
     */
    public function __construct(
        public int $id,
        public int $quizDiagnosticKeyId,
        public string $name,
        public string $description,
        public int $minValue,
        public int $maxValue,
    ) {
    }
}