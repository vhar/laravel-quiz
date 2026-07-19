<?php

namespace Vhar\Quiz\Http\Api\V1\QuizQuestion;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vhar\Quiz\Application\Services\EditAuthorizationResolver;
use Vhar\Quiz\Application\Services\ModelResolver;
use Vhar\Quiz\Models\QuizQuestion;

/**
 * Class DeleteQuestionRequest
 *
 * Handles HTTP authorization criteria and scope verification for removing a quiz question.
 *
 * @package Vhar\Quiz\Http\Api\V1\QuizQuestion
 */
class DeleteQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * Validates that the question belongs to the target quiz scope and that the user possesses destructive modification rights.
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

        // Fast DB check for ownership context
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }
}