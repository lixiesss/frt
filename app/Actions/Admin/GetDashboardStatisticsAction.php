<?php

namespace App\Actions\Admin;

use App\Enums\Department;
use App\Models\Applicant;

class GetDashboardStatisticsAction
{
    public function execute(): array
    {
        $totalApplicants = Applicant::count();
        $applicantsByStage = Applicant::selectRaw('stage, count(*) as count')
            ->groupBy('stage')
            ->get()
            ->pluck('count', 'stage')
            ->toArray();

        $applicantsByDepartment = Applicant::selectRaw('first_choice_department as department, count(*) as count')
            ->groupBy('first_choice_department')
            ->get()
            ->map(function ($item) {
                $department = Department::tryFrom($item->department);
                return [
                    'department' => $department ? $department->label() : 'Unknown',
                    'count' => $item->count,
                ];
            })
            ->toArray();

        $codingTestApplicants = Applicant::where('requires_coding_test', true)->count();

        return [
            'total_applicants' => $totalApplicants,
            'applicants_by_stage' => $applicantsByStage,
            'applicants_by_department' => $applicantsByDepartment,
            'coding_test_applicants' => $codingTestApplicants,
        ];
    }
}
