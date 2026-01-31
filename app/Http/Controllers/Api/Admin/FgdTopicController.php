<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFgdTopicRequest;
use App\Http\Requests\Admin\UpdateFgdTopicRequest;
use App\Http\Resources\FgdTopicResource;
use App\Models\FgdTopic;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class FgdTopicController extends Controller
{
    use ApiResponses;

    /**
     * Display a listing of FGD topics.
     */
    public function index(): JsonResponse
    {
        $topics = FgdTopic::with('groups')->get();
        
        return $this->successResponse(FgdTopicResource::collection($topics));
    }

    /**
     * Store a newly created FGD topic.
     */
    public function store(StoreFgdTopicRequest $request): JsonResponse
    {
        $topic = FgdTopic::create($request->validated());
        
        return $this->createdResponse(
            new FgdTopicResource($topic),
            'FGD topic created successfully'
        );
    }

    /**
     * Display the specified FGD topic.
     */
    public function show(string $id): JsonResponse
    {
        $topic = FgdTopic::with('groups')->findOrFail($id);
        
        return $this->successResponse(new FgdTopicResource($topic));
    }

    /**
     * Update the specified FGD topic.
     */
    public function update(UpdateFgdTopicRequest $request, string $id): JsonResponse
    {
        $topic = FgdTopic::findOrFail($id);
        $topic->update($request->validated());
        
        return $this->successResponse(
            new FgdTopicResource($topic),
            'FGD topic updated successfully'
        );
    }

    /**
     * Remove the specified FGD topic.
     */
    public function destroy(string $id): JsonResponse
    {
        $topic = FgdTopic::findOrFail($id);
        $topic->delete();
        
        return $this->successResponse([], 'FGD topic deleted successfully');
    }

    /**
     * Get all tests for a specific FGD topic.
     */
    public function tests(string $id): JsonResponse
    {
        $topic = FgdTopic::findOrFail($id);
        $tests = $topic->tests()->get();
        
        return $this->successResponse(\App\Http\Resources\FgdTestResource::collection($tests));
    }
}
