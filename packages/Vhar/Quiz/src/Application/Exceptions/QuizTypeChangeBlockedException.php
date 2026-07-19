<?php

namespace Vhar\Quiz\Application\Exceptions;

use RuntimeException;

/**
 * Class QuizTypeChangeBlockedException
 *
 * Thrown when a quiz type modification is rejected due to existing type-specific relations.
 *
 * @package Vhar\Quiz\Application\Exceptions
 */
final class QuizTypeChangeBlockedException extends RuntimeException
{
    /**
     * Create an instance for blocked Diagnostic-to-Knowledge conversion.
     */
    public static function dueToExistingDiagnosticKeys(): self
    {
        return new self(
            "Cannot change quiz type from DIAGNOSTIC because it already has associated diagnostic keys."
        );
    }

    /**
     * Create an instance for blocked Knowledge-to-Diagnostic conversion.
     */
    public static function dueToExistingResultLevels(): self
    {
        return new self(
            "Cannot change quiz type from KNOWLEDGE because it already has associated result levels."
        );
    }
}