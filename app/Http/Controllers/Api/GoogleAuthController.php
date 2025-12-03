<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name'     => $googleUser->getName(),
                    'username' => strtolower(str_replace(' ', '', $googleUser->getName())) . rand(100,999),
                    'email'    => $googleUser->getEmail(),
                    'avatar'   => $googleUser->getAvatar(),
                    'role'     => 'user',
                    'password' => Hash::make('google-' . $googleUser->getId()),
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;
            return redirect("http://localhost:5173/google/callback?token={$token}");

        } catch (\Exception $e) {
            return redirect("http://localhost:5173/login?error=google_failed");
        }
    }
}
