<?php

namespace App\Http\Requests\Applicant;

use App\Enums\Department;
use App\Enums\Gender;
use App\Enums\Major;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApplicationRequest extends FormRequest
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
        $isDraft = $this->boolean('is_draft', false);
        $required = $isDraft ? 'nullable' : 'required';
        
        $cnbRequired = function (string $inputField) use ($isDraft) {
            return function () use ($isDraft, $inputField) {
                if ($isDraft) return false;
                return $this->input($inputField) === Department::CNB->value;
            };
        };
        
        return [
            'is_draft' => ['sometimes', 'boolean'],
            'name' => [$required, 'string', 'max:255'],
            'nrp' => ['required', 'string', 'size:9', 'unique:applicants,nrp'],
            'major' => [$required, Rule::enum(Major::class)],
            'gpa' => [$required, 'numeric', 'min:0', 'max:4'],
            'gender' => [$required, Rule::enum(Gender::class)],
            'visi' => [$required, 'string'],
            'misi' => [$required, 'string'],
            'value' => [$required, 'string'],
            'cv' => [$required, 'file', 'mimes:pdf', 'max:2048'],
            
            'first_choice_department' => [$required, Rule::enum(Department::class)],
            'first_choice_motivation' => [$required, 'string'],
            'first_choice_commitment' => [$required, 'string'],
            'first_choice_portfolio' => [
                Rule::requiredIf($cnbRequired('first_choice_department')),
                'nullable',
                'file',
                'mimes:pdf,zip',
                'max:10240'
            ],
            
            'second_choice_department' => [$required, Rule::enum(Department::class), 'different:first_choice_department'],
            'second_choice_motivation' => [$required, 'string'],
            'second_choice_commitment' => [$required, 'string'],
            'second_choice_portfolio' => [
                Rule::requiredIf($cnbRequired('second_choice_department')),
                'nullable',
                'file',
                'mimes:pdf,zip',
                'max:10240'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'second_choice_department.different' => 'Second choice department must be different from first choice.',
        ];
    }
}
