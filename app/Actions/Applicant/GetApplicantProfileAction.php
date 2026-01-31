<?php

namespace App\Actions\Applicant;

use App\Models\Applicant;

class GetApplicantProfileAction
{
    public function execute(string $id): ?Applicant
    {
        return Applicant::with([
            'group.topic',
            'group.session',
            'departmentQuestions',
        ])->findOrFail($id);
    }
}
