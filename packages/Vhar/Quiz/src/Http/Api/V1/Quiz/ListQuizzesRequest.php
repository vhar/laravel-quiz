<?php

namespace Vhar\Quiz\Http\Api\V1\Quiz;

use Illuminate\Foundation\Http\FormRequest;
use Vhar\Quiz\Application\Queries\Quiz\ListQuizzes\QuizFilters;
use Illuminate\Validation\Rules\Enum;
use Vhar\Quiz\Enums\QuizAgeRestrictionEnum;
use Vhar\Quiz\Enums\QuizAvailabilityEnum;
use Vhar\Quiz\Enums\QuizTypeEnum;

final class ListQuizzesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quiz_type' => [
                'sometimes',
                'array',
            ],

            'quiz_type.*' => [
                'string',
                new Enum(QuizTypeEnum::class),
            ],

            'age_restriction' => [
                'sometimes',
                'array',
            ],

            'age_restriction.*' => [
                'string',
                new Enum(QuizAgeRestrictionEnum::class),
            ],

            'duration_range' => [
                'sometimes',
                'array',
            ],

            'duration_range.*' => [
                'integer',
                'exists:quiz_duration_ranges,id',
            ],

            'has_time_limit' => [
                'sometimes',
                'boolean',
            ],

            'has_attempt_limit' => [
                'sometimes',
                'boolean',
            ],

            'availability' => [
                'sometimes',
                new Enum(QuizAvailabilityEnum::class),
            ],

            'tags' => [
                'sometimes',
                'array',
            ],

            'tags.*' => [
                'integer',
            ],

            'sort' => [
                'sometimes',
                'string',
            ],

            'page' => [
                'sometimes',
                'integer',
                'min:1',
            ],

            'per_page' => [
                'sometimes',
                'integer',
                'min:1',
                'max:100',
            ],
        ];
    }

    public function filters(): QuizFilters
    {
        return new QuizFilters(
            quizTypes: collect($this->input('quiz_type', []))
                ->map(
                    fn(string $value) =>
                    QuizTypeEnum::from($value)
                )
                ->all(),

            ageRestrictions: collect($this->input('age_restriction', []))
                ->map(
                    fn(string $value) =>
                    QuizAgeRestrictionEnum::from($value)
                )
                ->all(),

            durationRangeIds: $this->input(
                'duration_range',
                []
            ),

            hasTimeLimit: $this->has('has_time_limit')
            ? $this->boolean('has_time_limit')
            : null,

            hasAttemptLimit: $this->has('has_attempt_limit')
            ? $this->boolean('has_attempt_limit')
            : null,

            availability: $this->has('availability')
            ? QuizAvailabilityEnum::from(
                $this->string('availability')
            )
            : null,

            tagIds: $this->input(
                'tags',
                []
            ),
        );
    }
}