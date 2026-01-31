<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Applicant;
use App\Models\FgdGroup;

class FgdGroupPolicy
{
    /**
     * Determine whether the user can view any models.
     * Only admins can manage FGD groups.
     */
    public function viewAny(Admin|Applicant $user): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine whether the user can view the model.
     * Only admins can view FGD groups.
     */
    public function view(Admin|Applicant $user, FgdGroup $fgdGroup): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine whether the user can create models.
     * Only admins can create FGD groups.
     */
    public function create(Admin|Applicant $user): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine whether the user can update the model.
     * Only admins can update FGD groups.
     */
    public function update(Admin|Applicant $user, FgdGroup $fgdGroup): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine whether the user can delete the model.
     * Only admins can delete FGD groups.
     */
    public function delete(Admin|Applicant $user, FgdGroup $fgdGroup): bool
    {
        return $user instanceof Admin;
    }
}
