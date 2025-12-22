<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BundleController extends Controller
{
    public function index()
    {
        $bundles = Bundle::with('theme')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        // Add full URL for profile images
        $bundles->transform(function ($bundle) {
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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'theme_id' => 'required|exists:themes,id',
            'description' => 'nullable|string|max:50',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',

             'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $slug = Str::slug($value);
                    $exists = Bundle::where('user_id', auth()->id())
                        ->where('slug', $slug)
                        ->exists();

                    if ($exists) {
                        $fail('Nama bundle sudah dipakai, silakan gunakan nama lain.');
                    }
                }
            ],

            'instagram_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
            'facebook_url' => 'nullable|url',
            'x_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
        ]);

        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')
                ->store('avatars', 'public');
        }

        $bundle = Bundle::create([
            'id' => (string) Str::uuid(),
            'user_id' => auth()->id(),
            'theme_id' => $request->theme_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'profile_image' => $imagePath,

            'instagram_url' => $request->instagram_url,
            'github_url' => $request->github_url,
            'tiktok_url' => $request->tiktok_url,
            'facebook_url' => $request->facebook_url,
            'x_url' => $request->x_url,
            'youtube_url' => $request->youtube_url,
        ]);

        $bundle->profile_image_url = $imagePath
            ? asset('storage/' . $imagePath)
            : null;

        return response()->json([
            'success' => true,
            'data' => $bundle->load('theme'),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $bundle = Bundle::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'theme_id' => 'sometimes|required|exists:themes,id',
            'description' => 'nullable|string|max:50',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',

            'instagram_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
            'facebook_url' => 'nullable|url',
            'x_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
        ]);

        $updateData = $request->only([
            'name',
            'theme_id',
            'description',
            'instagram_url',
            'github_url',
            'tiktok_url',
            'facebook_url',
            'x_url',
            'youtube_url',
        ]);

        // Handle profile image update
        if ($request->hasFile('profile_image')) {
            if ($bundle->profile_image && Storage::disk('public')->exists($bundle->profile_image)) {
                Storage::disk('public')->delete($bundle->profile_image);
            }

            $updateData['profile_image'] = $request->file('profile_image')
                ->store('avatars', 'public');
        }

        $bundle->update($updateData);
        $bundle->refresh();

        $bundle->profile_image_url = $bundle->profile_image
            ? asset('storage/' . $bundle->profile_image)
            : null;

        return response()->json([
            'success' => true,
            'data' => $bundle->load('theme'),
        ]);
    }

    public function destroy($id)
    {
        $bundle = Bundle::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($bundle->profile_image && Storage::disk('public')->exists($bundle->profile_image)) {
            Storage::disk('public')->delete($bundle->profile_image);
        }

        $bundle->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bundle deleted',
        ]);
    }

    public function showPublic($slug)
    {
        $bundle = Bundle::with('theme')
            ->where('slug', $slug)
            ->firstOrFail();

        $bundle->profile_image_url = $bundle->profile_image
            ? asset('storage/' . $bundle->profile_image)
            : null;

        return response()->json([
            'success' => true,
            'data' => $bundle,
        ]);
    }
}
