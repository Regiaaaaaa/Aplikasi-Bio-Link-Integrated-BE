<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserAppeal;
use App\Models\User;
use Illuminate\Http\Request;

class AdminAppealController extends Controller
{
   // Get All Banding Users
    public function index()
    {
        $appeals = UserAppeal::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'data' => $appeals
        ]);
    }

   // Approve Banding User
    public function approve(Request $request, $id)
    {
        $appeal = UserAppeal::findOrFail($id);

        // Block Double Proccess
        if ($appeal->status !== 'pending') {
            return response()->json([
                'message' => 'Banding ini sudah diproses'
            ], 409);
        }

        $user = User::findOrFail($appeal->user_id);

        // IF User Active
        if ($user->is_active) {
            return response()->json([
                'message' => 'User sudah aktif'
            ], 409);
        }

        // Update appeal
        $appeal->update([
            'status'       => 'approved',
            'admin_reply'  => $request->admin_reply ?? 'Banding diterima'
        ]);

        // User Active
        $user->update([
            'is_active'   => true,
            'ban_message' => null
        ]);

        return response()->json([
            'message' => 'Banding disetujui & user berhasil diaktifkan',
            'appeal'  => $appeal
        ]);
    }

    // Reject Banding
    public function reject(Request $request, $id)
    {
        $appeal = UserAppeal::findOrFail($id);

        // Block Double Proccess
        if ($appeal->status !== 'pending') {
            return response()->json([
                'message' => 'Banding ini sudah diproses'
            ], 409);
        }

        $appeal->update([
            'status'       => 'rejected',
            'admin_reply'  => $request->admin_reply ?? 'Banding ditolak'
        ]);

        return response()->json([
            'message' => 'Banding ditolak',
            'appeal'  => $appeal
        ]);
    }
}
