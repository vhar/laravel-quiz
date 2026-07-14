<?php

namespace Vhar\Quiz\Http\Api\V1\Quiz;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;
use Vhar\Quiz\Enums\QuizAgeRestrictionEnum;
use Vhar\Quiz\Enums\QuizScoringTypeEnum;
use Vhar\Quiz\Enums\QuizTypeEnum;
use Vhar\Quiz\Rules\Quiz\ScoringTypeRequiredForKnowledgeQuiz;

final class CreateQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        if (!$this->filled('slug') && $this->filled('title')) {
            $this->merge([
                'slug' => Str::slug(
                    $this->string('title')->toString(),
                    language: 'ru'
                ),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'required',
                'string',
                'max:255',
                'unique:quizzes,slug',
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
                'nullable',
                new Enum(QuizAgeRestrictionEnum::class),
            ],

            'attempt_limit' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'time_limit' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'scoring_type' => [
                new ScoringTypeRequiredForKnowledgeQuiz(
                    $this->enum('quiz_type', QuizTypeEnum::class)
                ),
                'nullable',
                new Enum(QuizScoringTypeEnum::class),
            ],

            'change_answer' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}