<?php

namespace App\Http\Requests\Admin;

use App\Enums\FgdCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFgdSessionRequest extends FormRequest
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
            'schedule' => ['sometimes', 'date'],
            'place' => ['sometimes', 'string', 'max:255'],
            'category' => ['sometimes', Rule::enum(FgdCategory::class)],
        ];
    }
}
