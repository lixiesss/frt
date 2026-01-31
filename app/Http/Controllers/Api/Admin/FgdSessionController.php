<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFgdSessionRequest;
use App\Http\Requests\Admin\UpdateFgdSessionRequest;
use App\Http\Resources\FgdSessionResource;
use App\Models\FgdSession;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class FgdSessionController extends Controller
{
    use ApiResponses;

    /**
     * Display a listing of FGD sessions.
     */
    public function index(): JsonResponse
    {
        $sessions = FgdSession::with(['groups'])->get();
        
        return $this->successResponse(FgdSessionResource::collection($sessions));
    }

    /**
     * Store a newly created FGD session.
     */
    public function store(StoreFgdSessionRequest $request): JsonResponse
    {
        $session = FgdSession::create($request->validated());
        
        return $this->createdResponse(
            new FgdSessionResource($session),
            'FGD session created successfully'
        );
    }

    /**
     * Display the specified FGD session.
     */
    public function show(string $id): JsonResponse
    {
        $session = FgdSession::with(['groups'])->findOrFail($id);
        
        return $this->successResponse(new FgdSessionResource($session));
    }

    /**
     * Update the specified FGD session.
     */
    public function update(UpdateFgdSessionRequest $request, string $id): JsonResponse
    {
        $session = FgdSession::findOrFail($id);
        $session->update($request->validated());
        
        return $this->successResponse(
            new FgdSessionResource($session),
            'FGD session updated successfully'
        );
    }

    /**
     * Remove the specified FGD session.
     */
    public function destroy(string $id): JsonResponse
    {
        $session = FgdSession::findOrFail($id);
        $session->delete();
        
        return $this->successResponse([], 'FGD session deleted successfully');
    }
}
