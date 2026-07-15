<?php

namespace Vhar\Quiz\Http\Api\V1\QuizQuestion;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vhar\Quiz\Models\QuizQuestion;

/**
 * Class DeleteQuestionRequest
 *
 * Validates route integrity before executing the deletion of a quiz question.
 *
 * @package Vhar\Quiz\Http\Api\V1\QuizQuestion
 */
final class DeleteQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to perform this operation.
     * * Validates the aggregate boundary: the question must belong to the specified quiz.
     *
     * @return bool
     * @throws NotFoundHttpException If the question is not linked to the scoped quiz.
     */
    public function authorize(): bool
    {
        if ($this->user() === null) {
            return false;
        }

        $quizId = (int) $this->route('quizId');
        $questionId = (int) $this->route('questionId');

        // Resolve the actual parent quiz_id from DB
        $actualQuizId = (int) QuizQuestion::where('id', $questionId)->value('quiz_id');

        // If the question doesn't exist or is mapped to another quiz, immediately abort with 404
        if ($actualQuizId === 0 || $actualQuizId !== $quizId) {
            throw new NotFoundHttpException('Question not found within the specified quiz scope.');
        }

        return true;
    }

    /**
     * Deletion requires no payload validation rules.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }
}