
text/x-generic forgot-password.blade.php ( HTML document, UTF-8 Unicode text, with CRLF line terminators )
@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="min-h-screen bg-white flex items-center justify-center py-8 px-4">

    <div class="w-full max-w-[480px]">

        <div class="text-center mb-8">
            <h1 class="text-3xl sm:text-4xl font-bold uppercase tracking-wide text-slate-800">
                Forgot Password
            </h1>
            <p class="text-gray-600 mt-4 text-[15px] sm:text-[17px]">
                Enter your email address and we will send you a One-Time Password (OTP).
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

        <form method="POST" action="{{ route('customer.password.email') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-[15px] sm:text-[17px] font-medium mb-3 text-gray-700">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    required
                    class="w-full h-14 sm:h-[70px] border border-gray-300 px-5 text-base sm:text-[17px] rounded-2xl outline-none focus:border-black transition"
                    placeholder="your@email.com"
                >
            </div>

            <button 
                type="submit"
                class="w-full h-14 sm:h-[58px] bg-[#222] text-white text-[15px] sm:text-[17px] font-semibold uppercase tracking-wider rounded-2xl hover:bg-gray-800 transition"
            >
                Send OTP
            </button>

            <div class="text-center">
                <a href="{{ route('customer.login') }}" 
                   class="text-[15px] sm:text-[17px] underline hover:text-black transition">
                    ← Back to Login
                </a>
            </div>
        </form>

    </div>

</div>
@endsection