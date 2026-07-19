<?php

namespace Vhar\Quiz\Http\Api\V1\QuizDiagnosticKey;

use Illuminate\Foundation\Http\FormRequest;
use Vhar\Quiz\Application\Services\EditAuthorizationResolver;
use Vhar\Quiz\Application\Services\ModelResolver;
use Vhar\Quiz\Models\QuizDiagnosticKey;

/**
 * Class DeleteDiagnosticKeyRequest
 *
 * Handles HTTP authorization criteria for deleting a quiz diagnostic key.
 *
 * @package Vhar\Quiz\Http\Api\V1\QuizDiagnosticKey
 */
class DeleteDiagnosticKeyRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }
}