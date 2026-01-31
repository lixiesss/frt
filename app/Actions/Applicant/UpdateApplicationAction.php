<?php

namespace App\Actions\Applicant;

use App\Models\Applicant;
use App\Traits\FileUploadHandler;
use Illuminate\Support\Facades\DB;

class UpdateApplicationAction
{
    use FileUploadHandler;

    public function __construct(
        protected AssignDepartmentQuestionsAction $assignQuestionsAction
    ) {
    }

    public function execute(Applicant $applicant, array $data): Applicant
    {
        return DB::transaction(function () use ($applicant, $data) {
            $wasDraft = $applicant->is_draft;
            
            $departmentChanged = false;
            if (isset($data['first_choice_department'])) {
                $currentFirst = $applicant->first_choice_department?->value;
                $departmentChanged = $currentFirst !== $data['first_choice_department'];
            }
            if (!$departmentChanged && isset($data['second_choice_department'])) {
                $currentSecond = $applicant->second_choice_department?->value;
                $departmentChanged = $currentSecond !== $data['second_choice_department'];
            }
            
            // Handle CV upload
            if (isset($data['cv'])) {
                // Delete old CV if exists
                if ($applicant->cv_path) {
                    $this->deleteFile($applicant->cv_path);
                }
                $data['cv_path'] = $this->uploadCV($data['cv'], $data['name'], $applicant->nrp);
                unset($data['cv']);
            }

            // Handle first choice portfolio upload
            if (isset($data['first_choice_portfolio'])) {
                if ($applicant->first_choice_portfolio_path) {
                    $this->deleteFile($applicant->first_choice_portfolio_path);
                }
                $data['first_choice_portfolio_path'] = $this->uploadPortfolio(
                    $data['first_choice_portfolio'],
                    $applicant->nrp,
                    1
                );
                unset($data['first_choice_portfolio']);
            }

            // Handle second choice portfolio upload
            if (isset($data['second_choice_portfolio'])) {
                if ($applicant->second_choice_portfolio_path) {
                    $this->deleteFile($applicant->second_choice_portfolio_path);
                }
                $data['second_choice_portfolio_path'] = $this->uploadPortfolio(
                    $data['second_choice_portfolio'],
                    $applicant->nrp,
                    2
                );
                unset($data['second_choice_portfolio']);
            }

            // Update draft status if provided
            if (isset($data['is_draft'])) {
                $data['is_draft'] = (bool) $data['is_draft'];
            }
            
            // Set requires_coding_test if applying to IS department
            $firstChoiceDept = $data['first_choice_department'] ?? $applicant->first_choice_department?->value;
            $secondChoiceDept = $data['second_choice_department'] ?? $applicant->second_choice_department?->value;
            $data['requires_coding_test'] = 
                $firstChoiceDept === 'IS' || $secondChoiceDept === 'IS';

            // Update applicant
            $applicant->update($data);

            // Auto-assign or re-assign department questions
            $isNowSubmitted = !($data['is_draft'] ?? $applicant->is_draft);
            if (($wasDraft && $isNowSubmitted) || ($departmentChanged && $isNowSubmitted)) {
                // Remove existing questions if department changed
                if ($departmentChanged && $applicant->departmentQuestions()->exists()) {
                    $applicant->departmentQuestions()->detach();
                }
                
                // Assign new questions
                if (!$applicant->departmentQuestions()->exists()) {
                    $this->assignQuestionsAction->execute($applicant->fresh());
                }
            }

            return $applicant->fresh();
        });
    }
}
