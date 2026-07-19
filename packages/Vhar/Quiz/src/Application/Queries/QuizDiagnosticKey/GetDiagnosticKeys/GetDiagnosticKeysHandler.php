<?php

namespace Vhar\Quiz\Application\Queries\QuizDiagnosticKey\GetDiagnosticKeys;

use Vhar\Quiz\Application\Exceptions\InvalidQuizTypeException;
use Vhar\Quiz\Application\Mappers\QuizDiagnosticKeyViewMapper;
use Vhar\Quiz\Application\Views\QuizDiagnosticKeyView;
use Vhar\Quiz\Models\Quiz;
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
     * @throws InvalidQuizTypeException If the target quiz does not match the diagnostic type.
     */
    public function handle(GetDiagnosticKeysQuery $query): array
    {
        /** @var Quiz $quiz */
        $quiz = Quiz::query()->findOrFail($query->quizId);

        if ($quiz->quiz_type !== \Vhar\Quiz\Enums\QuizTypeEnum::DIAGNOSTIC) {
            throw InvalidQuizTypeException::forDiagnosticKeys($quiz->quiz_type->value);
        }

        $keys = QuizDiagnosticKey::query()
            ->where('quiz_id', $quiz->id)
            ->with(['levels' => fn($dbQuery) => $dbQuery->orderBy('min_value')])
            ->orderBy('sort')
            ->get();

        return $keys->map(
            fn(QuizDiagnosticKey $key) => $this->mapper->fromModel($key)
        )->toArray();
    }
}