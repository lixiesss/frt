<?php

namespace App\Http\Controllers\Api;

use App\Enums\Department;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class DepartmentController extends Controller
{
    use ApiResponses;

    /**
     * Display a listing of departments.
     */
    public function index(): JsonResponse
    {
        $departments = collect(Department::cases())->map(function ($department) {
            return [
                'slug' => $department->slug(),
                'name' => $department->label(),
            ];
        });
        
        return $this->successResponse($departments);
    }
}
