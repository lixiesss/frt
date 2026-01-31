<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AssignApplicantToFgdGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fgd_group_id' => ['required', 'uuid', 'exists:fgd_groups,id'],
        ];
    }
}
