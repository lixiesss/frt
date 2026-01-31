<?php

namespace App\Http\Requests\Admin;

use App\Enums\FgdCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFgdSessionRequest extends FormRequest
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
            'schedule' => ['required', 'date'],
            'place' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::enum(FgdCategory::class)],
        ];
    }
}
