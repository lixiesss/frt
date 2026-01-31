<?php

namespace App\Http\Requests\Applicant;

use App\Enums\Department;
use App\Enums\Gender;
use App\Enums\Major;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApplicationRequest extends FormRequest
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
        $applicant = $this->route('applicant');
        $isDraft = $this->boolean('is_draft', $applicant->is_draft ?? false);
        
        $cnbRequired = function (string $inputField, string $dbField) use ($applicant, $isDraft) {
            return function () use ($inputField, $dbField, $applicant, $isDraft) {
                if ($isDraft) return false;
                
                $department = $this->input($inputField) ?? $applicant->{$dbField}?->value;
                
                return $department === Department::CNB->value && empty($applicant->{$dbField . '_portfolio_path'});
            };
        };
        
        return [
            'is_draft' => ['sometimes', 'boolean'],
            'nrp' => [
                'sometimes',
                'string',
                'size:9',
                Rule::unique('applicants', 'nrp')->ignore($applicant->id),
            ],
            'name' => ['sometimes', 'string', 'max:255'],
            'major' => ['sometimes', Rule::enum(Major::class)],
            'gpa' => ['sometimes', 'numeric', 'min:0', 'max:4'],
            'gender' => ['sometimes', Rule::enum(Gender::class)],
            'visi' => ['sometimes', 'string'],
            'misi' => ['sometimes', 'string'],
            'value' => ['sometimes', 'string'],
            'cv' => ['sometimes', 'file', 'mimes:pdf', 'max:2048'],
            
            'first_choice_department' => [
                'sometimes',
                Rule::enum(Department::class),
                function ($attribute, $value, $fail) use ($applicant) {
                    $secondChoice = $this->input('second_choice_department') ?? $applicant->second_choice_department?->value;
                    if ($secondChoice && $value === $secondChoice) {
                        $fail('First choice department must be different from second choice.');
                    }
                },
            ],
            'first_choice_motivation' => ['sometimes', 'string'],
            'first_choice_commitment' => ['sometimes', 'string'],
            'first_choice_portfolio' => [
                Rule::requiredIf($cnbRequired('first_choice_department', 'first_choice_department')),
                'nullable',
                'file',
                'mimes:pdf,zip',
                'max:10240'
            ],
            
            'second_choice_department' => [
                'sometimes',
                Rule::enum(Department::class),
                function ($attribute, $value, $fail) use ($applicant) {
                    $firstChoice = $this->input('first_choice_department') ?? $applicant->first_choice_department?->value;
                    if ($firstChoice && $value === $firstChoice) {
                        $fail('Second choice department must be different from first choice.');
                    }
                },
            ],
            'second_choice_motivation' => ['sometimes', 'string'],
            'second_choice_commitment' => ['sometimes', 'string'],
            'second_choice_portfolio' => [
                Rule::requiredIf($cnbRequired('second_choice_department', 'second_choice_department')),
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
            'first_choice_portfolio.required_if' => 'Portfolio is required for Creative n Branding department.',
            'second_choice_portfolio.required_if' => 'Portfolio is required for Creative n Branding department.',
        ];
    }
}
