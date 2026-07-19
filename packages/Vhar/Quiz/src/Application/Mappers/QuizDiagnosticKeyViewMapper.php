<?php

namespace Vhar\Quiz\Application\Mappers;

use Vhar\Quiz\Application\Views\QuizDiagnosticKeyLevelView;
use Vhar\Quiz\Application\Views\QuizDiagnosticKeyView;
use Vhar\Quiz\Models\QuizDiagnosticKey;
use Vhar\Quiz\Models\QuizDiagnosticKeyLevel;

/**
 * Class QuizDiagnosticKeyViewMapper
 *
 * Maps diagnostic key models and their structures into immutable read-model views.
 *
 * @package Vhar\Quiz\Application\Mappers
 */
final readonly class QuizDiagnosticKeyViewMapper
{
    /**
     * Map a QuizDiagnosticKey model to its read-model view representation.
     *
     * @param QuizDiagnosticKey $model
     * @return QuizDiagnosticKeyView
     */
    public function fromModel(QuizDiagnosticKey $model): QuizDiagnosticKeyView
    {
        $levels = [];

        if ($model->relationLoaded('levels')) {
            $levels = $model->levels->map(
                fn(QuizDiagnosticKeyLevel $level) => $this->fromLevelModel($level)
            )->toArray();
        }

        return new QuizDiagnosticKeyView(
            id: $model->id,
            quizId: $model->quiz_id,
            name: $model->name,
            description: $model->description,
            sort: $model->sort,
            levels: $levels
        );
    }

    /**
     * Map a individual QuizDiagnosticKeyLevel model to its view representation.
     *
     * @param QuizDiagnosticKeyLevel $level
     * @return QuizDiagnosticKeyLevelView
     */
    private function fromLevelModel(QuizDiagnosticKeyLevel $level): QuizDiagnosticKeyLevelView
    {
        return new QuizDiagnosticKeyLevelView(
            id: $level->id,
            quizDiagnosticKeyId: $level->quiz_diagnostic_key_id,
            name: $level->name,
            description: $level->description,
            minValue: $level->min_value,
            maxValue: $level->max_value
        );
    }
}