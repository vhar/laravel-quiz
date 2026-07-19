<?php

namespace Vhar\Quiz\Application\Exceptions;

use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class InvalidQuizTypeException
 *
 * Thrown when an operation is requested on a quiz with an incompatible type.
 * Automatically rendered as HTTP 422 Unprocessable Entity by Laravel.
 *
 * @package Vhar\Quiz\Application\Exceptions
 */
final class InvalidQuizTypeException extends UnprocessableEntityHttpException
{
    /**
     * Create a new instance for diagnostic keys constraint violation.
     *
     * @param int $currentType
     * @return self
     */
    public static function forDiagnosticKeys(int $currentType): self
    {
        return new self(
            sprintf("Diagnostic keys are only available for quiz type 2 (DIAGNOSTIC). Current type is %d.", $currentType)
        );
    }
}