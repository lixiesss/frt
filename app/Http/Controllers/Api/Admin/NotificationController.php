<?php

namespace App\Http\Controllers\Api\Admin;

use App\Actions\Admin\SendFgdNotificationAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SendFgdNotificationRequest;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    use ApiResponses;

    public function __construct(
        private SendFgdNotificationAction $sendFgdNotificationAction
    ) {}

    /**
     * Send FGD notification to applicants.
     */
    public function sendFgdNotification(SendFgdNotificationRequest $request): JsonResponse
    {
        $result = $this->sendFgdNotificationAction->execute(
            $request->input('applicant_ids')
        );
        
        return $this->successResponse($result, 'FGD notification sent successfully');
    }
}
