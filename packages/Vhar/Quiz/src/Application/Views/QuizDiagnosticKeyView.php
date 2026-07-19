<?php

namespace Vhar\Quiz\Application\Views;

/**
 * Class QuizDiagnosticKeyView
 *
 * Read-model representation of a quiz diagnostic key including its related levels.
 *
 * @package Vhar\Quiz\Application\Views
 */
final readonly class QuizDiagnosticKeyView
{
    /**
     * QuizDiagnosticKeyView constructor.
     *
     * @param int $id
     * @param int $quizId
     * @param string $name
     * @param string $description
     * @param int $sort
     * @param array<int, QuizDiagnosticKeyLevelView> $levels
     */
    public function __construct(
        public int $id,
        public int $quizId,
        public string $name,
        public string $description,
        public int $sort,
        public array $levels,
    ) {
    }
}