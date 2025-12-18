<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GoogleAuthController;
use App\Http\Controllers\Api\OtpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\UserAppealController;
use App\Http\Controllers\Api\AdminAppealController;


// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// OTP Forgot Password
Route::post('/send-otp', [OtpController::class, 'sendOtp']);
Route::post('/verify-otp', [OtpController::class, 'verifyOtp']);
Route::post('/reset-password', [OtpController::class, 'resetPassword']);

// Google OAuth
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect']);
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);


// User Routes
Route::middleware('auth:sanctum')->prefix('user')->group(function () {

    // Current user
    Route::get('/', function (Request $request) {
        $user = $request->user();
        
        // Url Avatar
        if ($user->avatar) {
            $user->avatar_url = asset('storage/' . $user->avatar);
        } else {
            $user->avatar_url = 'https://i.pravatar.cc/150';
        }
        
        return $user;
    });

    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Banding Procces 
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
    });
});

Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {

    // Get all users
    Route::get('/users', [AdminController::class, 'index']);

    // User De/Activate
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

});


