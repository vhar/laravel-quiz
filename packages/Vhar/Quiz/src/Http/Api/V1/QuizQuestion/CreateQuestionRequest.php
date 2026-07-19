<?php

namespace Vhar\Quiz\Http\Api\V1\QuizQuestion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Добавили фасад для удобной сборки правил
use Illuminate\Validation\Rules\Enum;
use Vhar\Quiz\Application\Services\EditAuthorizationResolver;
use Vhar\Quiz\Application\Services\ModelResolver;
use Vhar\Quiz\Enums\QuizQuestionTypeEnum;
use Vhar\Quiz\Models\Quiz;

/**
 * Class CreateQuestionRequest
 *
 * Handles HTTP validation and authorization criteria for creating a quiz question.
 *
 * @package Vhar\Quiz\Http\Api\V1\QuizQuestion
 */
class CreateQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param ModelResolver $modelResolver
     * @param EditAuthorizationResolver $authResolver
     * @return bool
     */
    public function authorize(ModelResolver $modelResolver, EditAuthorizationResolver $authResolver): bool
    {
        $quizId = (int) $this->route('quizId');

        /** @var Quiz $quiz */
        $quiz = $modelResolver->resolve('quiz', $quizId);

        $authResolver->authorize($quiz, $this->user());

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $quizId = (int) $this->route('quizId');

        return [
            // Проверяем уникальность пары quiz_id + number для создаваемого вопроса
            'number' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('quiz_questions', 'number')
                    ->where('quiz_id', $quizId)
            ],
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', new Enum(QuizQuestionTypeEnum::class)],
            'score' => ['sometimes', 'integer', 'min:0'],
            'video_url' => ['sometimes', 'nullable', 'url'],
        ];
    }
}