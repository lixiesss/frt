<?php

namespace App\Http\Controllers\Api\Admin;

use App\Actions\Admin\GetApplicantDetailAction;
use App\Actions\Admin\GetApplicantsByDepartmentAction;
use App\Actions\Applicant\AdvanceApplicationStageAction;
use App\Actions\Applicant\AssignToGroupAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateApplicationStageRequest;
use App\Http\Requests\Admin\AssignApplicantToFgdGroupRequest;
use App\Http\Resources\ApplicantResource;
use App\Models\Applicant;
use App\Models\FgdGroup;
use App\Traits\ApiResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    use ApiResponses, AuthorizesRequests;

    public function __construct(
        private GetApplicantsByDepartmentAction $getApplicantsByDepartmentAction,
        private GetApplicantDetailAction $getApplicantDetailAction,
        private AdvanceApplicationStageAction $advanceStageAction,
        private AssignToGroupAction $assignToGroupAction
    ) {}

    /**
     * Display a listing of applicants with filters.
     */
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Applicant::class);
        
        $applicants = $this->getApplicantsByDepartmentAction->execute(
            $request->input('department'),
            $request->input('per_page', 15)
        );
        
        return $this->successResponse(ApplicantResource::collection($applicants));
    }

    /**
     * Advance applicant to next stage.
     */
    public function updateStage(UpdateApplicationStageRequest $request, string $id): JsonResponse
    {
        $applicant = Applicant::findOrFail($id);
        
        $this->authorize('updateStage', $applicant);
        
        $newStage = $request->input('stage');
        $applicant = $this->advanceStageAction->execute($applicant, $newStage);
        
        return $this->successResponse(
            new ApplicantResource($applicant),
            'Applicant stage advanced successfully'
        );
    }

    /**
     * Assign applicant to FGD group.
     */
    public function assignToGroup(AssignApplicantToFgdGroupRequest $request, string $id): JsonResponse
    {
        $applicant = Applicant::findOrFail($id);
        
        $this->authorize('assignToGroup', $applicant);
        
        $group = FgdGroup::findOrFail($request->input('fgd_group_id'));
        $applicant = $this->assignToGroupAction->execute($applicant, $group);
        
        return $this->successResponse(
            new ApplicantResource($applicant),
            'Applicant assigned to group successfully'
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $applicant = $this->getApplicantDetailAction->execute($id);
        
        if (!$applicant) {
            return $this->errorResponse('Applicant not found', 404);
        }
        
        $this->authorize('view', $applicant);
        
        return $this->successResponse(new ApplicantResource($applicant));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        return $this->errorResponse('Not implemented', 501);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        return $this->errorResponse('Not implemented', 501);
    }
}
