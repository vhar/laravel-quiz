<?php

namespace Vhar\Quiz\Http\Api\V1\Quiz;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Vhar\Quiz\Enums\QuizAgeRestrictionEnum;
use Vhar\Quiz\Enums\QuizScoringTypeEnum;
use Vhar\Quiz\Enums\QuizTypeEnum;
use Vhar\Quiz\Rules\Quiz\ScoringTypeRequiredForKnowledgeQuiz;

final class UpdateQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'quiz_type' => [
                'required',
                new Enum(QuizTypeEnum::class),
            ],

            'quiz_duration_range_id' => [
                'nullable',
                'integer',
                'exists:quiz_duration_ranges,id',
            ],

            'age_restriction' => [
                'required',
                new Enum(QuizAgeRestrictionEnum::class),
            ],

            'attempt_limit' => [
                'required',
                'integer',
                'min:0',
            ],

            'time_limit' => [
                'required',
                'integer',
                'min:0',
            ],

            'scoring_type' => [
                new ScoringTypeRequiredForKnowledgeQuiz(
                    $this->enum('quiz_type', QuizTypeEnum::class)
                ),
                Rule::when(
                    $this->input('scoring_type') !== null,
                    new Enum(QuizScoringTypeEnum::class)
                ),
            ],

            'change_answer' => [
                'required',
                'boolean',
            ],

            'quiz_settings' => [
                'nullable',
                'array',
            ],
        ];
    }
}