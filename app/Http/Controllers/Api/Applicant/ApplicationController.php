<?php

namespace App\Http\Controllers\Api\Applicant;

use App\Actions\Applicant\CreateApplicationAction;
use App\Actions\Applicant\UpdateApplicationAction;
use App\Actions\Applicant\GetApplicantProfileAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Applicant\StoreApplicationRequest;
use App\Http\Requests\Applicant\UpdateApplicationRequest;
use App\Http\Resources\ApplicantResource;
use App\Models\Applicant;
use App\Traits\ApiResponses;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    use ApiResponses, AuthorizesRequests;

    public function __construct(
        private CreateApplicationAction $createAction,
        private UpdateApplicationAction $updateAction,
        private GetApplicantProfileAction $getProfileAction
    ) {}

    /**
     * Display the authenticated applicant's profile.
     */
    public function index(Request $request): JsonResponse
    {
        $applicant = $this->getProfileAction->execute($request->user()->id);
        
        $this->authorize('view', $applicant);
        
        return $this->successResponse(new ApplicantResource($applicant));
    }

    /**
     * Store a newly created application.
     */
    public function store(StoreApplicationRequest $request): JsonResponse
    {
        $applicant = $this->createAction->execute($request->validated());
        
        return $this->createdResponse(
            new ApplicantResource($applicant),
            'Application submitted successfully'
        );
    }

    /**
     * Display the specified applicant.
     */
    public function show(string $id): JsonResponse
    {
        $applicant = $this->getProfileAction->execute($id);
        
        return $this->successResponse(new ApplicantResource($applicant));
    }

    /**
     * Update the specified application.
     */
    public function update(UpdateApplicationRequest $request, string $id): JsonResponse
    {
        $applicant = Applicant::findOrFail($id);
        
        $this->authorize('update', $applicant);
        
        $applicant = $this->updateAction->execute($applicant, $request->validated());
        
        return $this->successResponse(
            new ApplicantResource($applicant),
            'Application updated successfully'
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        return $this->errorResponse('Not implemented', 501);
    }
}
