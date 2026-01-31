<?php

namespace App\Http\Requests\Admin;

use App\Enums\TestType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFgdTestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'question' => ['sometimes', 'string'],
            'type' => ['sometimes', 'integer', Rule::in([TestType::PRETEST->value, TestType::POSTTEST->value])],
            'topic_id' => ['sometimes', 'string', 'exists:fgd_topics,id'],
        ];
    }
}
