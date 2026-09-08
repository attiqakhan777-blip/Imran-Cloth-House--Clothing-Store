<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class CustomerAuthController extends Controller
{
    // ====================== LOGIN ======================
    public function showLogin()
    {
        return view('frontend.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Logged in successfully.');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->onlyInput('email');
    }

    // ====================== REGISTER ======================
    public function showRegister()
    {
        return view('frontend.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->email,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Account created successfully.');
    }

    // ====================== FORGOT PASSWORD WITH OTP ======================
    public function showForgotPassword()
    {
        return view('frontend.forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate OTP
        $otp = rand(100000, 999999);

        // Delete old OTPs
        PasswordResetOtp::where('email', $request->email)->delete();

        // Save new OTP
        PasswordResetOtp::create([
            'email'       => $request->email,
            'otp'         => $otp,
            'expires_at'  => Carbon::now()->addMinutes(10),
        ]);

        // Send OTP Email
        Mail::to($user->email)->send(new OtpMail($otp));

        // Store email in session
        session(['password_reset_email' => $request->email]);

        return redirect('/verify-otp')
                     ->with('success', 'OTP has been sent to your email.');
    }

    // ====================== VERIFY OTP ======================
    public function showVerifyOtp()
    {
        return view('frontend.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $email = session('password_reset_email');

        if (!$email) {
            return redirect('/account/forgot-password')
                         ->withErrors(['email' => 'Session expired. Please try again.']);
        }

        $resetOtp = PasswordResetOtp::where('email', $email)
                    ->where('otp', $request->otp)
                    ->where('expires_at', '>', Carbon::now())
                    ->first();

        if (!$resetOtp) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        session(['password_reset_verified' => true]);

        return redirect('/reset-password');
    }

    // ====================== RESET PASSWORD ======================
    public function showResetPassword()
    {
        if (!session('password_reset_verified')) {
            return redirect('/account/forgot-password');
        }

        return view('frontend.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $email = session('password_reset_email');

        if (!$email || !session('password_reset_verified')) {
            return redirect('/account/forgot-password');
        }

        $user = User::where('email', $email)->first();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Cleanup
        PasswordResetOtp::where('email', $email)->delete();
        session()->forget(['password_reset_email', 'password_reset_verified']);

        return redirect('/account/login')
                         ->with('success', 'Password reset successfully. Please login.');
    }

    // ====================== LOGOUT ======================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
public function orders()
{
    $orders = \App\Models\Order::where('customer_id', auth()->id())
                ->with(['items.product'])   // eager load items + product
                ->latest()
                ->get();

    return view('frontend.orders', compact('orders'));
}
}