<?php

namespace App\Actions\Applicant;

use App\Models\Applicant;
use App\Models\FgdGroup;

class AssignToGroupAction
{
    public function execute(Applicant $applicant, FgdGroup $group): Applicant
    {
        $applicant->update([
            'group_id' => $group->id,
        ]);

        return $applicant->fresh();
    }
}
