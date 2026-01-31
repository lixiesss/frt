<?php

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\HandleGoogleOAuthAction;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    use ApiResponses;

    public function __construct(
        private HandleGoogleOAuthAction $handleGoogleOAuthAction,
    ) {}

    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        $user = $this->handleGoogleOAuthAction->execute();
        $isUserAdmin = $user instanceof Admin;
        $guard = $isUserAdmin ? 'admin' : 'applicant'; 
        $path = $isUserAdmin ? '/admin' : '/';

        Auth::guard($guard)->login($user);
        session(['user_type' => $guard]);

        $request->session()->regenerate();
        $request->session()->save();

        $frontendUrl = rtrim(config('app.frontend_url', 'http://localhost:4321'), '/');
        
        return redirect()->away($frontendUrl . $path);
    }

    public function logout(Request $request): JsonResponse
    {
        $guard = session('user_type', 'applicant');
        if (Auth::guard($guard)->check()) {
            Auth::guard($guard)->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->successResponse([], 'Logout successful');
    }

    public function me(Request $request): JsonResponse
    {
        $guard = session('user_type', 'applicant');
        $user = Auth::guard($guard)->user();

        if (!$user) {
            return $this->errorResponse('Unauthenticated', 401);
        }

        return $this->successResponse($user);
    }
}
