<?php

namespace Vhar\Quiz\Http\Api\V1\QuizQuestion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vhar\Quiz\Enums\QuizQuestionTypeEnum;
use Vhar\Quiz\Models\QuizQuestion;

/**
 * Class UpdateQuestionRequest
 *
 * Handles validation for updating a quiz question payload.
 * Validates aggregate boundaries and route integrity before processing rules.
 *
 * @package Vhar\Quiz\Http\Api\V1\QuizQuestion
 */
final class UpdateQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * * We use this method to strictly validate that the question belongs 
     * to the specified quiz before any field validation rules are executed.
     *
     * @return bool
     * @throws NotFoundHttpException If the question does not belong to the scoped quiz.
     */
    public function authorize(): bool
    {
        if ($this->user() === null) {
            return false;
        }

        $quizId = (int) $this->route('quizId');
        $questionId = (int) $this->route('questionId');

        // Check the actual owner relationship in the database
        $actualQuizId = (int) QuizQuestion::where('id', $questionId)->value('quiz_id');

        // If relation is broken or question doesn't exist, throw 404 immediately
        if ($actualQuizId === 0 || $actualQuizId !== $quizId) {
            throw new NotFoundHttpException('Question not found within the specified quiz scope.');
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $questionId = $this->route('questionId');
        $quizId = (int) $this->route('quizId'); // Guaranteed to be correct thanks to authorize()

        return [
            'number' => [
                'required',
                'integer',
                'min:1',
                // Scopes uniqueness strictly within the validated quiz, ignoring current question
                Rule::unique('quiz_questions', 'number')
                    ->where('quiz_id', $quizId)
                    ->ignore($questionId),
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
     * Get custom messages for validator errors.
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