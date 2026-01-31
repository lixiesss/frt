<?php

namespace App\Http\Controllers\Api;

use App\Enums\Major;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class MajorController extends Controller
{
    use ApiResponses;

    /**
     * Display a listing of majors.
     */
    public function index(): JsonResponse
    {
        $majors = collect(Major::cases())->map(function ($major) {
            return [
                'value' => $major->value,
                'label' => $major->label(),
            ];
        });
        
        return $this->successResponse($majors);
    }
}
