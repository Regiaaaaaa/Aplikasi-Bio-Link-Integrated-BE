<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->avatar_url = $user->avatar
                ? asset('storage/' . $user->avatar)
                : null;
        }

        return response()->json(['users' => $users]);
    }

    public function activate($id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'is_active' => true,
            'ban_message' => null
        ]);

        return response()->json([
            'message' => 'User activated successfully',
            'user' => $user
        ]);
    }

    public function deactivate(Request $request, $id)
    {
        $request->validate([
            'ban_message' => 'required|string|max:1000'
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'is_active' => false,
            'ban_message' => $request->ban_message
        ]);

        return response()->json([
            'message' => 'User deactivated successfully',
            'user' => $user
        ]);
    }
}