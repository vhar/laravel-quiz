<?php

namespace Vhar\Quiz\Http\Api\V1\QuizDiagnosticKey;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Vhar\Quiz\Application\Views\QuizDiagnosticKeyView;

/**
 * Class UpdateDiagnosticKeyResponse
 *
 * Formats the read-model state of the updated diagnostic key into an API payload.
 *
 * @property-read QuizDiagnosticKeyView $resource
 * @package Vhar\Quiz\Http\Api\V1\QuizDiagnosticKey
 */
class UpdateDiagnosticKeyResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'quiz_id' => $this->resource->quizId,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'sort' => $this->resource->sort,
            'levels' => collect($this->resource->levels)->map(fn($level) => [
                'id' => $level->id,
                'quiz_diagnostic_key_id' => $level->quizDiagnosticKeyId,
                'name' => $level->name,
                'description' => $level->description,
                'min_value' => $level->minValue,
                'max_value' => $level->maxValue,
            ])->toArray(),
        ];
    }
}