<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use App\Models\Link;
use App\Models\LogBundle;
use App\Models\LogLink;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PublicController extends Controller
{
    // Link di buka/klik
    public function redirectLink($id)
    {
        $link = Link::findOrFail($id);

        // Simpan log/link dengan error handling
        try {
            LogLink::create([
                'id' => (string) Str::uuid(),
                'link_id' => $link->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Exception $e) {
            // Log error tapi tetap redirect (jangan ganggu user experience)
            Log::error('Failed to log link click', [
                'link_id' => $link->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        // Redirect ke url asli
        return redirect()->away($link->url);
    }

    // Ketika bundle di klik/buka
    public function openBundle($slug)
    {
        $bundle = Bundle::where('slug', $slug)->firstOrFail();

        // Simpan log bundle dengan error handling
        try {
            LogBundle::create([
                'id' => (string) Str::uuid(),
                'bundle_id' => $bundle->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        } catch (\Exception $e) {
            // Log error tapi tetap return data (jangan ganggu user experience)
            Log::error('Failed to log bundle open', [
                'bundle_id' => $bundle->id,
                'slug' => $slug,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        // Tampilkan data bundle
        return response()->json([
            'success' => true,
            'data' => $bundle->load('links', 'theme'),
        ]);
    }
}
