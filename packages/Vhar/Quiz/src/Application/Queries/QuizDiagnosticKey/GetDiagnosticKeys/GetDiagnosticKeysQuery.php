<?php

namespace Vhar\Quiz\Application\Queries\QuizDiagnosticKey\GetDiagnosticKeys;

/**
 * Class GetDiagnosticKeysQuery
 *
 * Immutable data transfer object containing criteria for retrieving diagnostic keys.
 *
 * @package Vhar\Quiz\Application\Queries\QuizDiagnosticKey\GetDiagnosticKeys
 */
final readonly class GetDiagnosticKeysQuery
{
    /**
     * GetDiagnosticKeysQuery constructor.
     *
     * @param int $quizId Scope identifier filter.
     */
    public function __construct(
        public int $quizId
    ) {
    }
}