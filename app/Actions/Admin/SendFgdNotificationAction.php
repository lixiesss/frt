<?php

namespace App\Actions\Admin;

use App\Models\Applicant;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendFgdNotificationAction
{
    public function execute(array $applicantIds): array
    {
        $sent = [];
        $failed = [];

        $applicants = Applicant::whereIn('id', $applicantIds)
            ->with('group.session')
            ->get();

        foreach ($applicants as $applicant) {
            try {
                // TODO: notification email
                
                $sent[] = $applicant->id;
            } catch (\Exception $e) {
                Log::error('Failed to send FGD notification to ' . $applicant->nrp, [
                    'error' => $e->getMessage(),
                ]);
                $failed[] = $applicant->id;
            }
        }

        return [
            'sent' => $sent,
            'failed' => $failed,
            'total' => count($applicantIds),
        ];
    }
}
