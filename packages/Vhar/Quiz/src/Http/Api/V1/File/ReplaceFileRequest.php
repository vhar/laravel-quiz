<?php

namespace Vhar\Quiz\Http\Api\V1\File;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validates file replacement requests.
 */
final class ReplaceFileRequest extends FormRequest
{
    /**
     * Determine whether the user is authorized to make this request.
     *
     * Authorization is handled separately by EditAuthorizationResolver.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get validation rules for file replacement.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'model_type' => [
                'required',
                'string',
                Rule::in(
                    array_keys(config('quiz.fileable_models'))
                ),
            ],

            'model_id' => [
                'required',
                'integer',
                'min:1',
            ],

            'file' => [
                'required',
                'file',
            ],
        ];
    }
}