<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFgdGroupRequest;
use App\Http\Requests\Admin\UpdateFgdGroupRequest;
use App\Http\Requests\Admin\AssignApplicantToFgdGroupRequest;
use App\Http\Resources\FgdGroupResource;
use App\Models\Applicant;
use App\Models\FgdGroup;
use App\Traits\ApiResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class FgdGroupController extends Controller
{
    use ApiResponses, AuthorizesRequests;

    /**
     * Display a listing of FGD groups.
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', FgdGroup::class);
        
        $groups = FgdGroup::with(['session', 'topic', 'applicants'])->get();
        
        return $this->successResponse(FgdGroupResource::collection($groups));
    }

    /**
     * Store a newly created FGD group.
     */
    public function store(StoreFgdGroupRequest $request): JsonResponse
    {
        $this->authorize('create', FgdGroup::class);
        
        $group = FgdGroup::create($request->validated());
        
        return $this->createdResponse(
            new FgdGroupResource($group),
            'FGD group created successfully'
        );
    }

    /**
     * Display the specified FGD group.
     */
    public function show(string $id): JsonResponse
    {
        $group = FgdGroup::with(['session', 'topic', 'applicants'])->findOrFail($id);
        
        $this->authorize('view', $group);
        
        return $this->successResponse(new FgdGroupResource($group));
    }

    /**
     * Update the specified FGD group.
     */
    public function update(UpdateFgdGroupRequest $request, string $id): JsonResponse
    {
        $group = FgdGroup::findOrFail($id);
        
        $this->authorize('update', $group);
        
        $group->update($request->validated());
        
        return $this->successResponse(
            new FgdGroupResource($group),
            'FGD group updated successfully'
        );
    }

    /**
     * Remove the specified FGD group.
     */
    public function destroy(string $id): JsonResponse
    {
        $group = FgdGroup::findOrFail($id);
        
        $this->authorize('delete', $group);
        
        $group->delete();
        
        return $this->successResponse([], 'FGD group deleted successfully');
    }

    /**
     * Assign applicant to group.
     */
    public function assignApplicant(AssignApplicantToFgdGroupRequest $request, string $id): JsonResponse
    {
        $group = FgdGroup::findOrFail($id);
        $applicant = Applicant::findOrFail($request->input('applicant_id'));
        $applicant->fgd_group_id = $id;
        $applicant->save();
        
        return $this->successResponse(
            new FgdGroupResource($group->load('applicants')),
            'Applicant assigned to group successfully'
        );
    }
}
