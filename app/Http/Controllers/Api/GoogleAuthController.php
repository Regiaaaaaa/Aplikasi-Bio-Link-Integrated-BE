<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect();
    }

    // File: GoogleAuthController.php

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::where('email', $googleUser->getEmail())->first();

            // ... (logika create user tetap sama)

            // Ambil URL Frontend dari ENV, default ke localhost jika tidak ada
            $frontendUrl = env('FRONTEND_URL', 'http://localhost:5173');

            // Check User Banned
            if (! $user->is_active) {
                return redirect(
                    $frontendUrl.'/login?error=banned&message='.
                    urlencode($user->ban_message ?? 'Akun anda dibanned')
                );
            }

            // Create Token
            $token = $user->createToken('auth_token')->plainTextToken;

            // Redirect ke Frontend dengan token
            return redirect($frontendUrl."/google/callback?token={$token}");

        } catch (\Exception $e) {
            return redirect(env('FRONTEND_URL', 'http://localhost:5173').'/login?error=google_failed');
        }
    }
}
