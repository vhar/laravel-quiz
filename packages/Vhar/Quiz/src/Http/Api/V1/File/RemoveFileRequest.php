<?php

namespace Vhar\Quiz\Http\Api\V1\File;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class RemoveFileRequest extends FormRequest
{
    /**
     * Determine whether request is authorized.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Validation rules.
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
            ],
        ];
    }
}