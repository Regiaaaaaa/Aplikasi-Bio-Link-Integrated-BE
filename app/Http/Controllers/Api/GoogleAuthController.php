<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    // Redirect
    public function redirect()
    {
        $redirectUrl = Socialite::driver('google')
            ->stateless() 
            ->redirect()
            ->getTargetUrl();

        return response()->json([
            'url' => $redirectUrl
        ]);
    }

    // Callback
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            
            $user = User::where('email', $googleUser->getEmail())->first();

            // KALO BELUM ADA → BUAT BARU
            if (!$user) {
                $user = User::create([
                    'name'     => $googleUser->getName(),
                    'username' => strtolower(str_replace(' ', '', $googleUser->getName())) . rand(100,999),
                    'email'    => $googleUser->getEmail(),
                    'avatar'   => $googleUser->getAvatar(),
                    'role'     => 'user',
                    'password' => Hash::make('google-' . $googleUser->getId()), // password random
                ]);
            }

            // Sanctum Token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login Google berhasil',
                'token'   => $token,
                'user'    => $user
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Authentication Google gagal',
                'detail' => $e->getMessage()
            ], 500);
        }
    }
}
