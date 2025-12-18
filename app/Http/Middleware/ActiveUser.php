<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ActiveUser
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user && !$user->is_active) {
            return response()->json([
                'message'     => $user->ban_message ?? 'Akun Anda dibanned',
                'can_appeal'  => true
            ], 403);
        }

        return $next($request);
    }
}
