<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinkController extends Controller
{

    public function index($bundleId)
    {
        $bundle = Bundle::where('id', $bundleId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $bundle->links()->latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'bundle_id' => 'required|exists:bundles,id',
            'name' => 'required|string|max:255',
            'url' => 'required|url',
        ]);

        // Ensure the bundle belongs to the authenticated user
        $bundle = Bundle::where('id', $request->bundle_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $link = Link::create([
            'id' => (string) Str::uuid(),
            'bundle_id' => $bundle->id,
            'name' => $request->name,
            'url' => $request->url,
        ]);

        return response()->json([
            'success' => true,
            'data' => $link
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url',
        ]);

        $link = Link::where('id', $id)
            ->whereHas('bundle', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->firstOrFail();

        $link->update([
            'name' => $request->name,
            'url' => $request->url,
        ]);

        return response()->json([
            'success' => true,
            'data' => $link
        ]);
    }

    public function destroy($id)
    {
        $link = Link::where('id', $id)
            ->whereHas('bundle', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->firstOrFail();

        $link->delete();

        return response()->json([
            'success' => true,
            'message' => 'Link deleted'
        ]);
    }
}
