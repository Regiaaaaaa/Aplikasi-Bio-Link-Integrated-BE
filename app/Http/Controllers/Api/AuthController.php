<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:100',
            'username'    => 'required|string|max:50|unique:users,username',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:6',
        ]);

        $user = User::create([
            'name'         => $request->name,
            'username'     => $request->username,
            'email'        => $request->email,
            'phone_number' => null,
            'password'     => Hash::make($request->password),
            'role'         => 'user',
            'is_active'    => true,
            'last_active'  => null, 
        ]);

        return response()->json([
            'message' => 'Register berhasil',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        // Cek user tidak ditemukan / password salah
        if (!$user || !$user->password || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        // Cek user aktif
        if (!$user->is_active) {
            return response()->json([
                'message' => 'Kami Mendeteksi Pelanggaran Pada Akun Anda. Silahkan Hubungi Admin Untuk Informasi Lebih Lanjut.'
            ], 403);
        }

        // Update last active
        $user->update([
            'last_active' => now(),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token'   => $token,
            'user'    => $user->fresh() 
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }
}
