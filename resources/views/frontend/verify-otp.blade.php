@extends('layouts.app')

@section('title', 'Verify OTP')

@section('content')
<div class="min-h-screen bg-white flex items-center justify-center py-8 px-4 sm:px-6">

    <div class="w-full max-w-[480px]">

        <div class="text-center mb-10">
            <h1 class="text-3xl sm:text-4xl font-bold uppercase tracking-wide text-slate-800">
                Verify OTP
            </h1>
            <p class="text-gray-600 mt-4 text-[15px] sm:text-[17px]">
                Enter the 6-digit OTP sent to<br>
                <strong class="text-black">{{ session('password_reset_email') }}</strong>
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-700 rounded-2xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-2xl text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/verify-otp" class="space-y-6">
            @csrf

            <div>
                <label class="block text-[16px] sm:text-[17px] font-medium mb-3 text-gray-700">
                    Enter OTP <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="otp" 
                    maxlength="6"
                    inputmode="numeric"
                    pattern="[0-9]{6}"
                    required
                    class="w-full h-14 sm:h-[70px] border border-gray-300 px-5 text-[28px] tracking-[12px] text-center outline-none focus:border-black font-mono rounded-2xl"
                    placeholder="123456"
                    autocomplete="off"
                >
            </div>

            <button 
                type="submit"
                class="w-full h-14 sm:h-[58px] bg-[#222] text-white text-[16px] sm:text-[17px] font-semibold uppercase tracking-wider rounded-2xl hover:bg-gray-800 transition"
            >
                Verify OTP
            </button>

            <div class="text-center">
                <a href="/account/forgot-password" 
                   class="text-[15px] sm:text-[17px] underline hover:text-black transition">
                    ← Change Email
                </a>
            </div>
        </form>

    </div>

</div>
@endsection