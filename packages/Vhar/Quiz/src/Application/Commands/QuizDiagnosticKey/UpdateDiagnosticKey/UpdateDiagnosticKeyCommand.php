<?php

namespace Vhar\Quiz\Application\Commands\QuizDiagnosticKey\UpdateDiagnosticKey;

/**
 * Class UpdateDiagnosticKeyCommand
 *
 * Data transfer object containing parameters required to update a diagnostic key and synchronize its levels.
 *
 * @package Vhar\Quiz\Application\Commands\QuizDiagnosticKey\UpdateDiagnosticKey
 */
final readonly class UpdateDiagnosticKeyCommand
{
    /**
     * UpdateDiagnosticKeyCommand constructor.
     *
     * @param int $id Diagnostic key ID.
     * @param int $quizId Parent quiz ID.
     * @param string $name Diagnostic key name.
     * @param string $description Diagnostic key description.
     * @param int $sort Sorting weight index.
     * @param array<int, array{id?: int, name: string, description: string, min_value: int, max_value: int}> $levels Collection of levels to synchronize.
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