<?php

use App\Http\Controllers\Api\AdminAppealController;
use App\Http\Controllers\Api\AdminBundleController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BundleController;
use App\Http\Controllers\Api\GoogleAuthController;
use App\Http\Controllers\Api\LinkController;
use App\Http\Controllers\Api\OtpController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PublicController;
use App\Http\Controllers\Api\ThemeController;
use App\Http\Controllers\Api\UserAppealController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Theme Routes
Route::get('/themes', [ThemeController::class, 'index'])
    ->middleware('throttle:60,1'); // Limit to 60 requests per minute

// Puclic Tracking
Route::get('/b/{slug}', [PublicController::class, 'openBundle'])
    ->middleware('throttle:120,1'); // Limit to 120 requests per minute
Route::get('/r/{id}', [PublicController::class, 'redirectLink'])
    ->middleware('throttle:200,1'); // Limit to 200 requests per minute

// Authentication Routes
Route::post('/register', [AuthController::class, 'register'])
    ->middleware('throttle:5,1'); // Limit to 5 requests per minute
Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1'); // Limit to 5 requests per minute

// OTP Forgot Password
Route::post('/send-otp', [OtpController::class, 'sendOtp'])
    ->middleware('throttle:3,1'); // Limit to 3 requests per minute
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])
    ->middleware('throttle:5,1'); // Limit to 5 requests per minute
Route::post('/reset-password', [OtpController::class, 'resetPassword'])
    ->middleware('throttle:3,1'); // Limit to 3 requests per minute

// Google OAuth
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])
    ->middleware('throttle:10,1'); // Limit to 10 requests per minute
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])
    ->middleware('throttle:10,1'); // Limit to 10 requests per minute

Route::middleware('auth:sanctum', 'throttle:300,1')->prefix('user')->group(function () {

    // Current user
    Route::get('/', function (Request $request) {
        $user = $request->user();

        // Url Avatar
        if ($user->avatar) {
            $user->avatar_url = asset('storage/'.$user->avatar);
        } else {
            $user->avatar_url = 'https://i.pravatar.cc/150';
        }

        return $user;
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('throttle:20,1'); // Limit to 20 requests per minute

    // Banding Process
    Route::post('/appeals', [UserAppealController::class, 'store']);
    Route::get('/appeals', [UserAppealController::class, 'index']);

    Route::middleware('active_user')->group(function () {

        // Profile routes
        Route::get('/profile', [ProfileController::class, 'getProfile']);
        Route::put('/profile', [ProfileController::class, 'updateProfile']);
        Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar']);

        // Password Settings Routes
        Route::post('/password/set', [ProfileController::class, 'setPassword']);
        Route::post('/password/change', [ProfileController::class, 'changePassword']);

        // Delete user
        Route::delete('/profile/delete', [ProfileController::class, 'deleteAccount']);

        // Bundle Routes
        Route::get('/bundles', [BundleController::class, 'index']);
        Route::post('/bundles', [BundleController::class, 'store'])
            ->middleware('throttle:30,1'); // Limit to 30 requests per minute
        Route::put('/bundles/{id}', [BundleController::class, 'update']);
        Route::delete('/bundles/{id}', [BundleController::class, 'destroy'])
            ->middleware('throttle:10,1'); // Limit to 10 requests per minute

        // Link Routes
        Route::get('/bundles/{bundleId}/links', [LinkController::class, 'index']);
        Route::post('/links', [LinkController::class, 'store'])
            ->middleware('throttle:50,1'); // Limit to 50 requests per minute
        Route::put('/links/{id}', [LinkController::class, 'update']);
        Route::delete('/links/{id}', [LinkController::class, 'destroy']);

    });
});

Route::middleware(['auth:sanctum', 'admin', 'throttle:120,1'])->prefix('admin')->group(function () {

    // Get all users
    Route::get('/users', [AdminController::class, 'index']);

    // User Activate / Deactivate
    Route::post('/users/{id}/activate', [AdminController::class, 'activate']);
    Route::post('/users/{id}/deactivate', [AdminController::class, 'deactivate']);

    // Profile Admin
    Route::get('/profile', [ProfileController::class, 'getProfile']);
    Route::put('/profile', [ProfileController::class, 'updateProfile']);
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar']);

    // Banding User
    Route::get('/appeals', [AdminAppealController::class, 'index']);
    Route::post('/appeals/{id}/approve', [AdminAppealController::class, 'approve']);
    Route::post('/appeals/{id}/reject', [AdminAppealController::class, 'reject']);

    // Bundle management
    Route::get('/bundles', [AdminBundleController::class, 'index']);
    Route::get('/users/{userId}/bundles', [AdminBundleController::class, 'byUser']);
    Route::get('/bundles/{id}', [AdminBundleController::class, 'show']);
    Route::delete('/bundles/{id}', [AdminBundleController::class, 'destroy']);

});
