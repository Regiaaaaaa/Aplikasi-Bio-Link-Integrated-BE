<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function getProfile()
    {
        return response()->json([
            'user' => Auth::user()
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'string|max:255',
            'username' => 'string|max:255|unique:users,username,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
        ]);

        $user->update($request->only(['name', 'username', 'phone_number']));

        return response()->json([
            'message' => 'Profile updated',
            'user' => $user
        ]);
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:2048'
        ]);

        $user = Auth::user();

        $path = $request->file('avatar')->store('avatars', 'public');

        $user->avatar = $path;
        $user->save();

        return response()->json([
            'message' => 'Avatar updated',
            'avatar_url' => asset('storage/' . $path)
        ]);
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $user = Auth::user();

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password set successfully']);
    }
}
