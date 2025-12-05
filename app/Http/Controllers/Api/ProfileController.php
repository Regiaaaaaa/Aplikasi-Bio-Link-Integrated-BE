<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function getProfile()
    {
        $user = Auth::user();
        
        //  Url Avatar
        if ($user->avatar) {
            $user->avatar_url = asset('storage/' . $user->avatar);
        } else {
            $user->avatar_url = 'https://i.pravatar.cc/150'; 
        }
        
        return response()->json([
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'string|max:255',
            'username' => 'string|max:255|unique:users,username,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:255',
        ]);

        $user->update($request->only(['name', 'username', 'phone_number', 'bio']));

        return response()->json([
            'message' => 'Profile updated',
            'user' => $user
        ]);
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240' 
        ]);

        $user = Auth::user();

        // Hapus avatar lama 
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Upload avatar baru
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