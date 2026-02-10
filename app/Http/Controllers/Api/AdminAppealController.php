<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAppeal;
use Illuminate\Http\Request;

class AdminAppealController extends Controller
{
    // Get All Banding Users
    public function index()
    {
        $appeals = UserAppeal::with('user:id,name,email,avatar,role,is_active,ban_message,created_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($appeal) {

                if ($appeal->user) {
                    $avatar = $appeal->user->avatar
                        ? basename($appeal->user->avatar)
                        : null;

                    // keep filename
                    $appeal->user->avatar = $avatar;

                    // INI YANG KEMARIN ILANG ❗
                    $appeal->user->avatar_url = $avatar
                        ? asset('storage/avatars/'.$avatar)
                        : null;
                }

                return $appeal;
            });

        return response()->json([
            'data' => $appeals,
        ]);
    }

    // Approve Banding User
    public function approve(Request $request, $id)
    {
        $appeal = UserAppeal::with('user')->findOrFail($id);

        // Block Double Proccess
        if ($appeal->status !== 'pending') {
            return response()->json([
                'message' => 'Banding ini sudah diproses',
            ], 409);
        }

        $user = User::findOrFail($appeal->user_id);

        // IF User Active
        if ($user->is_active) {
            return response()->json([
                'message' => 'User sudah aktif',
            ], 409);
        }

        // Update appeal
        $appeal->update([
            'status' => 'approved',
            'admin_reply' => $request->admin_reply ?? 'Banding diterima',
        ]);

        // User Active
        $user->update([
            'is_active' => true,
            'ban_message' => null,
        ]);

        // Reload data dengan user
        $appeal->refresh();
        $appeal->load('user');

        return response()->json([
            'message' => 'Banding disetujui & user berhasil diaktifkan',
            'appeal' => $appeal,
        ]);
    }

    // Reject Banding
    public function reject(Request $request, $id)
    {
        $appeal = UserAppeal::with('user')->findOrFail($id);

        // Block Double Proccess
        if ($appeal->status !== 'pending') {
            return response()->json([
                'message' => 'Banding ini sudah diproses',
            ], 409);
        }

        $appeal->update([
            'status' => 'rejected',
            'admin_reply' => $request->admin_reply ?? 'Banding ditolak',
        ]);

        // Reload data dengan user
        $appeal->refresh();
        $appeal->load('user');

        return response()->json([
            'message' => 'Banding ditolak',
            'appeal' => $appeal,
        ]);
    }
}
