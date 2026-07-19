<?php

namespace Vhar\Quiz\Application\Commands\QuizDiagnosticKey\DeleteDiagnosticKey;

/**
 * Class DeleteDiagnosticKeyCommand
 *
 * Data transfer object containing identifiers required to remove a diagnostic key.
 *
 * @package Vhar\Quiz\Application\Commands\QuizDiagnosticKey\DeleteDiagnosticKey
 */
final readonly class DeleteDiagnosticKeyCommand
{
    /**
     * DeleteDiagnosticKeyCommand constructor.
     *
     * @param int $id Diagnostic key ID.
     * @param int $quizId Parent quiz ID.
     */
    public function __construct(
        public int $id,
        public int $quizId,
    ) {
    }
}