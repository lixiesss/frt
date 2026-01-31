<?php

namespace App\Actions\Admin;

use App\Models\Applicant;
use Illuminate\Pagination\LengthAwarePaginator;

class GetApplicantsByDepartmentAction
{
    public function execute(?string $departmentId = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = Applicant::with(['group'])->submitted();

        if ($departmentId) {
            $query->byDepartmentChoice($departmentId);
        }

        return $query->paginate($perPage);
    }
}
