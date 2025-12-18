<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserAppeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAppealController extends Controller
{   
    public function store(Request $request)
    {
        $user = Auth::user();

        // For User Banned
        if ($user->is_active) {
            return response()->json([
                'message' => 'Akun Anda masih aktif, tidak perlu banding'
            ], 403);
        }

        // Check If Banding Pending
        $existing = UserAppeal::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Anda masih memiliki banding yang sedang diproses'
            ], 409);
        }

        // Validation
        $request->validate([
            'message' => 'required|string|min:5'
        ]);

        $appeal = UserAppeal::create([
            'user_id' => $user->id,
            'message' => $request->message,
            'status'  => 'pending',
        ]);

        return response()->json([
            'message' => 'Banding berhasil dikirim',
            'data'    => $appeal
        ], 201);
    }

    public function index()
    {
        $user = Auth::user();

        $appeals = UserAppeal::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'data' => $appeals
        ]);
    }
}
