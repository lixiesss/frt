<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Applicant;
use Illuminate\Auth\Access\Response;

class ApplicantPolicy
{
    /**
     * Determine whether the user can view any models.
     * Only admins can view all applicants.
     */
    public function viewAny(Admin|Applicant $user): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine whether the user can view the model.
     * Admins can view any applicant, applicants can only view themselves.
     */
    public function view(Admin|Applicant $user, Applicant $applicant): bool
    {
        if ($user instanceof Admin) {
            return true;
        }

        return $user->id === $applicant->id;
    }

    /**
     * Determine whether the user can create models.
     * Only applicants can create their application (once).
     */
    public function create(Admin|Applicant $user): bool
    {
        return $user instanceof Applicant;
    }

    /**
     * Determine whether the user can update the model.
     * Admins can update any applicant, applicants can only update themselves.
     */
    public function update(Admin|Applicant $user, Applicant $applicant): bool
    {
        if ($user instanceof Admin) {
            return true;
        }

        return $user->id === $applicant->id;
    }

    /**
     * Determine whether the user can update the stage.
     * Only admins can update applicant stages.
     */
    public function updateStage(Admin|Applicant $user, Applicant $applicant): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine whether the user can assign to group.
     * Only admins can assign applicants to FGD groups.
     */
    public function assignToGroup(Admin|Applicant $user, Applicant $applicant): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine whether the user can delete the model.
     * Only admins can delete applicants.
     */
    public function delete(Admin|Applicant $user, Applicant $applicant): bool
    {
        return $user instanceof Admin;
    }
}
