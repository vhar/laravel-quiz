<?php

namespace Vhar\Quiz\Http\Api\V1\QuizDiagnosticKey;

use Illuminate\Foundation\Http\FormRequest;
use Vhar\Quiz\Application\Services\EditAuthorizationResolver;
use Vhar\Quiz\Application\Services\ModelResolver;
use Vhar\Quiz\Models\QuizDiagnosticKey;
use Vhar\Quiz\Rules\DiagnosticKey\DiagnosticKeyLevelsRule;

/**
 * Class UpdateDiagnosticKeyRequest
 *
 * Handles HTTP validation and authorization criteria for updating a quiz diagnostic key.
 *
 * @package Vhar\Quiz\Http\Api\V1\QuizDiagnosticKey
 */
class UpdateDiagnosticKeyRequest extends FormRequest
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
        $keyId = (int) $this->route('keyId');

        /** @var QuizDiagnosticKey $key */
        $key = $modelResolver->resolve('diagnostic_key', $keyId);

        $authResolver->authorize($key, $this->user());

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $keyId = (int) $this->route('keyId');

        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'sort' => ['required', 'integer', 'min:0'],
            'levels' => ['required', 'array', 'min:1', new DiagnosticKeyLevelsRule($keyId)],
            'levels.*.id' => ['sometimes', 'integer', 'exists:quiz_diagnostic_key_levels,id'],
            'levels.*.name' => ['required', 'string', 'max:255'],
            'levels.*.description' => ['required', 'string'],
            'levels.*.min_value' => ['required', 'integer', 'min:0', 'max:100'],
            'levels.*.max_value' => ['required', 'integer', 'min:0', 'max:100', 'gte:levels.*.min_value'],
        ];
    }
}