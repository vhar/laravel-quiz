<?php

namespace Vhar\Quiz\Application\Commands\QuizDiagnosticKey\CreateDiagnosticKey;

/**
 * Class CreateDiagnosticKeyCommand
 *
 * Data transfer object carrying parameters to create a quiz diagnostic key along with its levels.
 *
 * @package Vhar\Quiz\Application\Commands\QuizDiagnosticKey\CreateDiagnosticKey
 */
final readonly class CreateDiagnosticKeyCommand
{
    /**
     * CreateDiagnosticKeyCommand constructor.
     *
     * @param int $quizId Target quiz ID.
     * @param string $name Diagnostic key name.
     * @param string $description Diagnostic key description.
     * @param int $sort Sorting weight index.
     * @param array<int, array{name: string, description: string, min_value: int, max_value: int}> $levels Required collection of key levels.
     */
    public function __construct(
        public int $quizId,
        public string $name,
        public string $description,
        public int $sort,
        public array $levels,
    ) {
    }
}