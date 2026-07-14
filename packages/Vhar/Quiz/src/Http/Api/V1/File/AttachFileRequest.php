<?php

namespace Vhar\Quiz\Http\Api\V1\File;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validates file attachment request.
 */
final class AttachFileRequest extends FormRequest
{
    /**
     * Determine whether the user is authorized.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get validation rules.
     *
     * @return array<string, mixed>
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