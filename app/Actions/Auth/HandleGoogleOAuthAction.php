<?php

namespace App\Actions\Auth;

use App\Models\Admin;
use App\Models\Applicant;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Contracts\Auth\Authenticatable;

class HandleGoogleOAuthAction
{
    public function execute(): Authenticatable
    {
        $googleUser = Socialite::driver('google')->stateless()->user();
        
        $email = $googleUser->getEmail();
        $name = $googleUser->getName();
        $nrp = substr($email, 0, 9);

        $admin = Admin::where('email', $email)->first();
        if ($admin) {
            return $admin;
        }

        $applicant = Applicant::firstOrCreate(
            ['nrp' => $nrp],
            [
                'name' => $name,
                'nrp' => $nrp,
            ]
        );

        return $applicant;
    }
}
