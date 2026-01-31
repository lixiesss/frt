<?php

namespace App\Actions\Admin;

use App\Models\Applicant;

class GetApplicantDetailAction
{
    public function execute(string $applicantId): ?Applicant
    {
        return Applicant::with([
            'group.topic',
            'group.session',
            'departmentQuestions',
            'fgdTests',
            'codingTestSubmissions.question',
        ])->find($applicantId);
    }
}
