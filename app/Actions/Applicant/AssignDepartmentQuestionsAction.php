<?php

namespace App\Actions\Applicant;

use App\Enums\QuestionType;
use App\Models\Applicant;
use App\Models\DepartmentQuestion;

class AssignDepartmentQuestionsAction
{
    public function execute(Applicant $applicant): void
    {
        $departments = collect([
            $applicant->first_choice_department,
            $applicant->second_choice_department,
        ])->filter();

        $questionIds = collect();

        foreach ($departments as $department) {
            $seriousQuestions = DepartmentQuestion::where('department', $department)
                ->where('type', QuestionType::SERIOUS)
                ->inRandomOrder()
                ->limit(2)
                ->pluck('id');

            $trollQuestion = DepartmentQuestion::where('department', $department)
                ->where('type', QuestionType::TROLL)
                ->inRandomOrder()
                ->limit(1)
                ->pluck('id');

            $questionIds = $questionIds->merge($seriousQuestions)->merge($trollQuestion);
        }

        $applicant->departmentQuestions()->attach($questionIds->toArray());
    }
}
