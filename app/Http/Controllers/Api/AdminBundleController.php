<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use App\Models\User;
use Illuminate\Http\Request;

class AdminBundleController extends Controller
{
    // Get All Bundles
    public function index(Request $request)
    {
        $bundles = Bundle::with(['user:id,name,email', 'theme'])
            ->withCount('links')
            ->latest()
            ->paginate(10);

        $bundles->through(function ($bundle) {
            $bundle->profile_image_url = $bundle->profile_image
                ? asset('storage/' . $bundle->profile_image)
                : null;
            return $bundle;
        });

        return response()->json([
            'success' => true,
            'data' => $bundles,
        ]);
    }

    // Get Bundles by User
    public function byUser($userId)
    {
        $user = User::select('id', 'name', 'email', 'is_active')
            ->findOrFail($userId);

        $bundles = Bundle::with('theme')
            ->withCount('links')
            ->where('user_id', $userId)
            ->latest()
            ->get();

        $bundles->transform(function ($bundle) {
            $bundle->profile_image_url = $bundle->profile_image
                ? asset('storage/' . $bundle->profile_image)
                : null;
            return $bundle;
        });

        return response()->json([
            'success' => true,
            'user' => $user,
            'bundles' => $bundles,
        ]);
    }

    // Get Bundle Details
    public function show($id)
    {
        $bundle = Bundle::with([
                'user:id,name,email',
                'theme',
                'links'
            ])
            ->withCount('links')
            ->findOrFail($id);

        $bundle->profile_image_url = $bundle->profile_image
            ? asset('storage/' . $bundle->profile_image)
            : null;

        return response()->json([
            'success' => true,
            'data' => $bundle,
        ]);
    }

    // Delete Bundle
    public function destroy($id)
    {
        $bundle = Bundle::findOrFail($id);

        if ($bundle->profile_image && \Storage::disk('public')->exists($bundle->profile_image)) {
            \Storage::disk('public')->delete($bundle->profile_image);
        }

        $bundle->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bundle berhasil dihapus oleh admin',
        ]);
    }
}
