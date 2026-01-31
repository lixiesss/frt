<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'nrp' => $this->nrp,
            'major' => $this->major?->value,
            'major_label' => $this->major?->label(),
            'gpa' => (float) $this->gpa,
            'gender' => $this->gender?->value,
            'stage' => $this->stage,
            'stage_label' => \App\Enums\ApplicationStage::tryFrom($this->stage)?->label(),
            'is_draft' => (bool) $this->is_draft,
            
            // Personal data
            'visi' => $this->visi,
            'misi' => $this->misi,
            'value' => $this->value,
            
            // File paths
            'cv_url' => $this->cv_path ? asset('storage/' . $this->cv_path) : null,
            
            // First choice
            'first_choice' => [
                'department' => $this->first_choice_department?->value,
                'department_name' => $this->first_choice_department?->label(),
                'motivation' => $this->first_choice_motivation,
                'commitment' => $this->first_choice_commitment,
                'portfolio_url' => $this->first_choice_portfolio_path ? asset('storage/' . $this->first_choice_portfolio_path) : null,
            ],
            
            // Second choice
            'second_choice' => [
                'department' => $this->second_choice_department?->value,
                'department_name' => $this->second_choice_department?->label(),
                'motivation' => $this->second_choice_motivation,
                'commitment' => $this->second_choice_commitment,
                'portfolio_url' => $this->second_choice_portfolio_path ? asset('storage/' . $this->second_choice_portfolio_path) : null,
            ],
            
            // FGD Group
            'group' => new FgdGroupResource($this->whenLoaded('group')),
            
            // Test
            'requires_coding_test' => (bool) $this->requires_coding_test,
            'department_answer_url' => $this->department_answer_path ? asset('storage/' . $this->department_answer_path) : null,
            
            // Timestamps
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
