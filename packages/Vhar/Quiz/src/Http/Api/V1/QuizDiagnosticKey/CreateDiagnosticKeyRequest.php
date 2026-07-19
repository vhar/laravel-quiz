<?php

namespace Vhar\Quiz\Http\Api\V1\QuizDiagnosticKey;

use Illuminate\Foundation\Http\FormRequest;
use Vhar\Quiz\Application\Services\EditAuthorizationResolver;
use Vhar\Quiz\Application\Services\ModelResolver;
use Vhar\Quiz\Models\Quiz;
use Vhar\Quiz\Rules\DiagnosticKey\DiagnosticKeyLevelsRule;

/**
 * Class CreateDiagnosticKeyRequest
 *
 * Handles HTTP validation and authorization criteria for creating a quiz diagnostic key.
 *
 * @package Vhar\Quiz\Http\Api\V1\QuizDiagnosticKey
 */
class CreateDiagnosticKeyRequest extends FormRequest
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

        // If authorization fails, EditAuthorizationResolver throws AuthorizationException, 
        // which returns a 403 response via your ExceptionHandler.
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'sort' => ['required', 'integer', 'min:0'],
            'levels' => ['required', 'array', 'min:1', new DiagnosticKeyLevelsRule()],
            'levels.*.name' => ['required', 'string', 'max:255'],
            'levels.*.description' => ['required', 'string'],
            'levels.*.min_value' => ['required', 'integer', 'min:0', 'max:100'],
            'levels.*.max_value' => ['required', 'integer', 'min:0', 'max:100', 'gte:levels.*.min_value'],
        ];
    }
}