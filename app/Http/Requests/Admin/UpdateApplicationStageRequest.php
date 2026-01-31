<?php

namespace App\Http\Requests\Admin;

use App\Enums\ApplicationStage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApplicationStageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stage' => ['required', 'integer', Rule::in([
                ApplicationStage::REGISTRATION->value,
                ApplicationStage::QUIZ->value,
                ApplicationStage::FGD->value,
                ApplicationStage::COMPLETED->value,
            ])],
        ];
    }
}
