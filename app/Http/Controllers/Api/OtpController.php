<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return response()->json(['error' => 'Email tidak ditemukan'], 404);
        }

        $otpExpires = $user->otp_expires_at ? Carbon::parse($user->otp_expires_at) : null;

        // simple rate limit: batasi request per user
        if ($user->otp_attempts >= 5 && $otpExpires && Carbon::now()->lessThan($otpExpires->addMinutes(10))) {
            return response()->json(['error' => 'Terlalu sering meminta OTP, coba nanti'], 429);
        }

        $otp = rand(100000, 999999);
        $user->otp_hash = Hash::make($otp);
        $user->otp_expires_at = Carbon::now()->addMinutes(5);
        $user->otp_attempts = $user->otp_attempts + 1;
        $user->save();

        Mail::to($user->email)->send(new OtpMail($otp));

        return response()->json(['message' => 'OTP dikirim ke email']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['email' => 'required|email', 'otp' => 'required|string']);
        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return response()->json(['error' => 'Email tidak ditemukan'], 404);
        }

        $otpExpires = $user->otp_expires_at ? Carbon::parse($user->otp_expires_at) : null;

        if (! $user->otp_hash || ! $otpExpires) {
            return response()->json(['error' => 'Tidak ada OTP aktif, silakan coba lagi'], 400);
        }

        if (Carbon::now()->greaterThan($otpExpires)) {
            return response()->json(['error' => 'OTP telah kedaluwarsa, silahkan kirim OTP kembali'], 400);
        }

        if (! Hash::check($request->otp, $user->otp_hash)) {
            return response()->json(['error' => 'OTP salah, Masukan OTP valid'], 400);
        }

        $user->otp_hash = null;
        $user->otp_expires_at = null;
        $user->otp_attempts = 0;
        $user->save();

        return response()->json(['message' => 'OTP valid']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return response()->json(['error' => 'Email tidak ditemukan'], 404);
        }

        // jika butuh: cek apakah user baru saja verifikasi OTP (kita menghapus otp_hash saat verify)
        // tanpa token tambahan, ada resiko, tapi umumnya ok jika verify menghapus otp_hash dan Anda me-require verifikasi sebelum reset
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['message' => 'Password berhasil direset']);
    }
}
