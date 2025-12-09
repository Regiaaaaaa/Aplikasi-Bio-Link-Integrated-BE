<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminController extends Controller
{
    // Ambil semua user
    public function index()
    {
        $users = User::all();

        foreach ($users as $user) {
            if ($user->avatar) {
                $user->avatar_url = asset('storage/' . $user->avatar);
            } else {
                $user->avatar_url = null;
            }
        }

        return response()->json([
            'users' => $users
        ]);
    }

    // Aktivasi user
    public function activate($id)
    {
        $user = User::findOrFail($id);

        $user->is_active = true;
        $user->save();

        return response()->json([
            'message' => 'User activated successfully',
            'user' => $user
        ]);
    }

    // Nonaktifkan user = banned
    public function deactivate($id)
    {
        $user = User::findOrFail($id);

        $user->is_active = false;
        $user->save();

        return response()->json([
            'message' => 'User deactivated successfully',
            'user' => $user
        ]);
    }
}
