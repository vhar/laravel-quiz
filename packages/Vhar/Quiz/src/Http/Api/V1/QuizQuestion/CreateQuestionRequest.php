<?php

namespace Vhar\Quiz\Http\Api\V1\QuizQuestion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Vhar\Quiz\Enums\QuizQuestionTypeEnum;

/**
 * Class CreateQuestionRequest
 *
 * Handles HTTP payload validation for quiz question creation.
 * Supports inline video attachments.
 *
 * @package Vhar\Quiz\Http\Api\V1\QuizQuestion
 */
final class CreateQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to perform this operation.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Rules to validate incoming payloads.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $quizId = $this->route('quizId');

        return [
            'number' => [
                'required',
                'integer',
                'min:1',
                // Unique sequential question numbering strictly scoped to the parent quiz
                Rule::unique('quiz_questions', 'number')->where(function ($query) use ($quizId) {
                    return $query->where('quiz_id', $quizId);
                }),
            ],
            'title' => [
                'required',
                'string',
                'max:65535',
            ],
            'type' => [
                'required',
                new Enum(QuizQuestionTypeEnum::class),
            ],
            'score' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'video_url' => [
                'nullable',
                'string',
                'url',
                'max:2048',
            ],
        ];
    }

    /**
     * Custom validation failure error messages in English.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'number.unique' => 'A question with this number already exists in this quiz.',
        ];
    }
}