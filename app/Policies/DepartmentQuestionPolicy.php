<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Applicant;
use App\Models\DepartmentQuestion;

class DepartmentQuestionPolicy
{
    /**
     * Determine whether the user can view any models.
     * Only admins can view department questions.
     */
    public function viewAny(Admin|Applicant $user): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine whether the user can view the model.
     * Only admins can view department questions.
     */
    public function view(Admin|Applicant $user, DepartmentQuestion $departmentQuestion): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine whether the user can create models.
     * Only admins from the same department can create questions for their department.
     */
    public function create(Admin|Applicant $user): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine whether the user can update the model.
     * Only admins from the same department can update their department's questions.
     */
    public function update(Admin|Applicant $user, DepartmentQuestion $departmentQuestion): bool
    {
        if (!($user instanceof Admin)) {
            return false;
        }

        // Admin can only update questions from their department
        return $user->managesDepartment($departmentQuestion->department);
    }

    /**
     * Determine whether the user can delete the model.
     * Only admins from the same department can delete their department's questions.
     */
    public function delete(Admin|Applicant $user, DepartmentQuestion $departmentQuestion): bool
    {
        if (!($user instanceof Admin)) {
            return false;
        }

        // Admin can only delete questions from their department
        return $user->managesDepartment($departmentQuestion->department);
    }
}
