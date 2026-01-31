<?php

namespace App\Http\Controllers\Api\Admin;

use App\Actions\Admin\GetDashboardStatisticsAction;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    use ApiResponses;

    public function __construct(
        private GetDashboardStatisticsAction $getDashboardStatisticsAction
    ) {}

    public function index(): JsonResponse
    {
        $stats = $this->getDashboardStatisticsAction->execute();
        
        return $this->successResponse($stats);
    }
}
