<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Theme;

class ThemeController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Theme::select('id', 'name')
                ->orderBy('name')
                ->get(),
        ]);
    }
}
