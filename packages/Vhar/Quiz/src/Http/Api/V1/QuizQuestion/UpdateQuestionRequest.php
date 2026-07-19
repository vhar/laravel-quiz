<?php

namespace Vhar\Quiz\Http\Api\V1\QuizQuestion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Добавили фасад для удобной сборки правил
use Illuminate\Validation\Rules\Enum;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vhar\Quiz\Application\Services\EditAuthorizationResolver;
use Vhar\Quiz\Application\Services\ModelResolver;
use Vhar\Quiz\Enums\QuizQuestionTypeEnum;
use Vhar\Quiz\Models\QuizQuestion;

/**
 * Class UpdateQuestionRequest
 *
 * Handles HTTP validation, scope verification, and authorization criteria for modifying an existing quiz question.
 *
 * @package Vhar\Quiz\Http\Api\V1\QuizQuestion
 */
class UpdateQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * Validates that the question belongs to the target quiz scope and that the user possesses modification rights.
     *
     * @param ModelResolver $modelResolver Domain entity retriever.
     * @param EditAuthorizationResolver $authResolver Security policy resolver.
     * @return bool
     *
     * @throws NotFoundHttpException When the question is not found or does not belong to the specified quiz.
     */
    public function authorize(ModelResolver $modelResolver, EditAuthorizationResolver $authResolver): bool
    {
        $quizId = (int) $this->route('quizId');
        $questionId = (int) $this->route('questionId');

        // Fast DB check for ownership context before full hydration
        $actualQuizId = (int) QuizQuestion::where('id', $questionId)->value('quiz_id');

        if ($actualQuizId === 0 || $actualQuizId !== $quizId) {
            throw new NotFoundHttpException('Question not found within the specified quiz scope.');
        }

        /** @var QuizQuestion $question */
        $question = $modelResolver->resolve('question', $questionId);

        $authResolver->authorize($question, $this->user());

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
        $questionId = (int) $this->route('questionId');

        return [
            // Проверяем уникальность пары quiz_id + number, исключая текущий ID вопроса
            'number' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('quiz_questions', 'number')
                    ->where('quiz_id', $quizId)
                    ->ignore($questionId)
            ],
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', new Enum(QuizQuestionTypeEnum::class)],
            'score' => ['sometimes', 'integer', 'min:0'],
            'video_url' => ['sometimes', 'nullable', 'url'],
        ];
    }
}