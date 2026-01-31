<?php

namespace App\Http\Requests\Admin;

use App\Enums\TestType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFgdTestRequest extends FormRequest
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
            'question' => ['required', 'string'],
            'type' => ['required', 'integer', Rule::in([TestType::PRETEST->value, TestType::POSTTEST->value])],
            'topic_id' => ['required', 'string', 'exists:fgd_topics,id'],
        ];
    }
}
