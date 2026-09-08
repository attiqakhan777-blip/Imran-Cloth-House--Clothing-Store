
text/x-generic login.blade.php ( HTML document, UTF-8 Unicode text, with CRLF line terminators )
@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen bg-white flex items-center justify-center py-8 px-4 sm:px-6">

    <div class="w-full max-w-[460px]">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-10">
            <h1 class="text-3xl sm:text-4xl font-bold text-black">
                Login
            </h1>

            <a href="{{ route('home') }}" 
               class="text-4xl leading-none text-black hover:text-gray-600 transition">
                &times;
            </a>
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

        <form method="POST" action="{{ route('customer.login.submit') }}">
            @csrf

            <div class="mb-6">
                <label class="block text-[16px] sm:text-[17px] font-medium mb-3 text-gray-700">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input 
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="your@email.com"
                    required
                    class="w-full h-14 sm:h-16 border border-gray-300 rounded-2xl px-5 text-base sm:text-[17px] outline-none focus:border-black transition"
                >
            </div>

            <div class="mb-8">
                <label class="block text-[16px] sm:text-[17px] font-medium mb-3 text-gray-700">
                    Password <span class="text-red-500">*</span>
                </label>
                <input 
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    required
                    class="w-full h-14 sm:h-16 border border-gray-300 rounded-2xl px-5 text-base sm:text-[17px] outline-none focus:border-black transition"
                >
            </div>

            <button 
                type="submit"
                class="w-full h-14 sm:h-16 bg-[#222] text-white text-base sm:text-[17px] font-semibold uppercase tracking-wider rounded-2xl hover:bg-gray-800 transition"
            >
                Log In
            </button>

            <div class="text-center mt-8">
                <a href="{{ route('customer.password.request') }}" 
                   class="text-[15px] sm:text-[17px] underline hover:text-black transition">
                    Forgot your password?
                </a>
            </div>

            <div class="mt-10">
                <a href="{{ route('customer.register') }}"
                   class="w-full h-14 sm:h-16 border border-gray-400 flex items-center justify-center text-base sm:text-[17px] uppercase tracking-wider text-black hover:bg-gray-50 transition rounded-2xl">
                    Create New Account
                </a>
            </div>
        </form>

    </div>
</div>
@endsection