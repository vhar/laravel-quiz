<?php

namespace Vhar\Quiz\Application\Queries\QuizDiagnosticKey\GetDiagnosticKeys;

use Vhar\Quiz\Application\Mappers\QuizDiagnosticKeyViewMapper;
use Vhar\Quiz\Application\Views\QuizDiagnosticKeyView;
use Vhar\Quiz\Models\QuizDiagnosticKey;

/**
 * Class GetDiagnosticKeysHandler
 *
 * Processes the database retrieval and transformation of diagnostic keys for a specific quiz scope.
 *
 * @package Vhar\Quiz\Application\Queries\QuizDiagnosticKey\GetDiagnosticKeys
 */
final readonly class GetDiagnosticKeysHandler
{
    /**
     * GetDiagnosticKeysHandler constructor.
     *
     * @param QuizDiagnosticKeyViewMapper $mapper Presentation layer transformer.
     */
    public function __construct(
        private QuizDiagnosticKeyViewMapper $mapper
    ) {
    }

    /**
     * Execute the retrieval operation.
     *
     * @param GetDiagnosticKeysQuery $query Evaluation criteria containing the quiz identifier.
     * @return array<int, QuizDiagnosticKeyView> Collection of mapped read-model structures.
     */
    public function handle(GetDiagnosticKeysQuery $query): array
    {
        $keys = QuizDiagnosticKey::query()
            ->where('quiz_id', $query->quizId)
            ->with(['levels' => fn($dbQuery) => $dbQuery->orderBy('min_value')])
            ->orderBy('sort')
            ->get();

        return $keys->map(
            fn(QuizDiagnosticKey $key) => $this->mapper->fromModel($key)
        )->toArray();
    }
}