<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\Bundle;
use App\Models\LogLink;
use App\Models\LogBundle;
use Illuminate\Support\Str;

class PublicController extends Controller
{
    // Link di buka/klil
    public function redirectLink($id)
    {
        $link = Link::findOrFail($id);

        // simpan log/link
        LogLink::create([
            'id' => (string) Str::uuid(),
            'link_id' => $link->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Redirect ke url asli 
        return redirect()->away($link->url);
    }

    // Ketika bundle di klil/buka
    public function openBundle($slug)
    {
        $bundle = Bundle::where('slug', $slug)->firstOrFail();

        // Simpan log bundle
        LogBundle::create([
            'id' => (string) Str::uuid(),
            'bundle_id' => $bundle->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        // Tampilkan data bundle 
        return response()->json([
            'success' => true,
            'data' => $bundle->load('links', 'theme'),
        ]);
    }
}
