<?php

namespace App\Actions\Applicant;

use App\Models\Applicant;

class AdvanceApplicationStageAction
{
    public function execute(Applicant $applicant, int $newStage): Applicant
    {
        $applicant->update(['stage' => $newStage]);

        return $applicant->fresh();
    }
}
