<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFgdTestRequest;
use App\Http\Requests\Admin\UpdateFgdTestRequest;
use App\Http\Resources\FgdTestResource;
use App\Models\FgdTest;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class FgdTestController extends Controller
{
    use ApiResponses;

    /**
     * Display a listing of FGD tests.
     */
    public function index(): JsonResponse
    {
        $tests = FgdTest::with('topic')->get();
        
        return $this->successResponse(FgdTestResource::collection($tests));
    }

    /**
     * Store a newly created FGD test.
     */
    public function store(StoreFgdTestRequest $request): JsonResponse
    {
        $test = FgdTest::create($request->validated())->load('topic');
        
        return $this->createdResponse(
            new FgdTestResource($test),
            'FGD test created successfully'
        );
    }

    /**
     * Display the specified FGD test.
     */
    public function show(string $id): JsonResponse
    {
        $test = FgdTest::with('topic')->findOrFail($id);
        
        return $this->successResponse(new FgdTestResource($test));
    }

    /**
     * Update the specified FGD test.
     */
    public function update(UpdateFgdTestRequest $request, string $id): JsonResponse
    {
        $test = FgdTest::findOrFail($id);
        $test->update($request->validated());
        $test->load('topic');
        
        return $this->successResponse(
            new FgdTestResource($test),
            'FGD test updated successfully'
        );
    }

    /**
     * Remove the specified FGD test.
     */
    public function destroy(string $id): JsonResponse
    {
        $test = FgdTest::findOrFail($id);
        $test->delete();
        
        return $this->successResponse([], 'FGD test deleted successfully');
    }
}
