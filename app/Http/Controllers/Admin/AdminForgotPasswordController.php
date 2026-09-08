<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AdminForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ]);

        $otp = rand(100000, 999999);

        DB::table('admin_password_reset_otps')->updateOrInsert(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        Mail::raw(
            "Your Admin Password Reset OTP is: $otp\n\nThis OTP will expire in 10 minutes.",
            function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Admin Password Reset OTP - Imran Cloth House');
            }
        );

        session(['admin_reset_email' => $request->email]);

        return redirect()
            ->route('admin.otp.form')
            ->with('success', 'OTP has been sent to your email.');
    }

    public function showOtpForm()
    {
        if (!session('admin_reset_email')) {
            return redirect()
                ->route('admin.password.request')
                ->withErrors(['email' => 'Please enter your email first.']);
        }

        return view('admin.auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $email = session('admin_reset_email');

        if (!$email) {
            return redirect()
                ->route('admin.password.request')
                ->withErrors(['email' => 'Session expired. Please try again.']);
        }

        $record = DB::table('admin_password_reset_otps')
            ->where('email', $email)
            ->where('otp', $request->otp)
            ->first();

        if (!$record) {
            return back()->withErrors([
                'otp' => 'Invalid OTP code.',
            ]);
        }

        if (Carbon::now()->greaterThan(Carbon::parse($record->expires_at))) {
            return back()->withErrors([
                'otp' => 'OTP has expired. Please request a new one.',
            ]);
        }

        session(['admin_otp_verified' => true]);

        return redirect()->route('admin.password.reset.form');
    }

    public function showResetForm()
    {
        if (!session('admin_otp_verified')) {
            return redirect()
                ->route('admin.password.request')
                ->withErrors(['email' => 'Please verify OTP first.']);
        }

        return view('admin.auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        if (!session('admin_otp_verified')) {
            return redirect()
                ->route('admin.password.request')
                ->withErrors(['email' => 'Please verify OTP first.']);
        }

        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $email = session('admin_reset_email');

        DB::table('admins')
            ->where('email', $email)
            ->update([
                'password' => Hash::make($request->password),
                'updated_at' => now(),
            ]);

        DB::table('admin_password_reset_otps')
            ->where('email', $email)
            ->delete();

        session()->forget([
            'admin_reset_email',
            'admin_otp_verified',
        ]);

        return redirect()
            ->route('admin.login')
            ->with('success', 'Password updated successfully. Please login.');
    }
}