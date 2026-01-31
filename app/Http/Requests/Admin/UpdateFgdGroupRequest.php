<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFgdGroupRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:255'],
            'topic_id' => ['sometimes', 'exists:fgd_topics,id'],
            'session_id' => ['sometimes', 'exists:fgd_sessions,id'],
            'mentor_name' => ['sometimes', 'string', 'max:255'],
        ];
    }
}
