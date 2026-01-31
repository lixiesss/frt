<?php

namespace App\Actions\Applicant;

use App\Models\Applicant;
use App\Traits\FileUploadHandler;
use Illuminate\Support\Facades\DB;

class CreateApplicationAction
{
    use FileUploadHandler;

    public function __construct(
        protected AssignDepartmentQuestionsAction $assignQuestionsAction
    ) {
    }

    public function execute(array $data): Applicant
    {
        return DB::transaction(function () use ($data) {
            // Handle CV upload
            if (isset($data['cv'])) {
                $data['cv_path'] = $this->uploadCV($data['cv'], $data['name'], $data['nrp']);
                unset($data['cv']);
            }

            // Handle first choice portfolio upload
            if (isset($data['first_choice_portfolio'])) {
                $data['first_choice_portfolio_path'] = $this->uploadPortfolio(
                    $data['first_choice_portfolio'],
                    $data['nrp'],
                    1
                );
                unset($data['first_choice_portfolio']);
            }

            // Handle second choice portfolio upload
            if (isset($data['second_choice_portfolio'])) {
                $data['second_choice_portfolio_path'] = $this->uploadPortfolio(
                    $data['second_choice_portfolio'],
                    $data['nrp'],
                    2
                );
                unset($data['second_choice_portfolio']);
            }

            // Set initial stage
            $data['stage'] = 0;
            
            // Set draft status
            $data['is_draft'] = $data['is_draft'] ?? false;

            $data['requires_coding_test'] = 
                ($data['first_choice_department'] ?? null) === 'IS' || 
                ($data['second_choice_department'] ?? null) === 'IS';

            $applicant = Applicant::create($data);
            
            // Auto-generate and assign department questions
            if (!($data['is_draft'] ?? false)) {
                $this->assignQuestionsAction->execute($applicant);
            }
            
            return $applicant;
        });
    }
}
