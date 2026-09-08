@extends('layouts.app')

@section('title', 'Create Account')

@section('content')
<div class="min-h-screen bg-white flex items-center justify-center py-8 px-4 sm:px-6">

    <div class="w-full max-w-[420px]">

        <div class="text-center mb-8">
            <h1 class="text-3xl sm:text-4xl font-bold uppercase tracking-wide text-black">
                Create Account
            </h1>
            <p class="text-gray-600 mt-3 text-[15px]">
                Register with your email and password
            </p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 text-sm rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 text-sm rounded-2xl">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('customer.register.submit') }}">
            @csrf

            <div class="mb-6">
                <label class="block text-[15px] font-medium mb-3 text-gray-700">
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    placeholder="your@email.com"
                    required
                    class="w-full h-14 sm:h-16 border border-gray-300 rounded-2xl px-5 text-base outline-none focus:border-black transition"
                >
            </div>

            <div class="mb-6">
                <label class="block text-[15px] font-medium mb-3 text-gray-700">
                    Password <span class="text-red-500">*</span>
                </label>
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Create a strong password"
                    required
                    class="w-full h-14 sm:h-16 border border-gray-300 rounded-2xl px-5 text-base outline-none focus:border-black transition"
                >
            </div>

            <div class="mb-8">
                <label class="block text-[15px] font-medium mb-3 text-gray-700">
                    Confirm Password <span class="text-red-500">*</span>
                </label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    placeholder="Confirm your password"
                    required
                    class="w-full h-14 sm:h-16 border border-gray-300 rounded-2xl px-5 text-base outline-none focus:border-black transition"
                >
            </div>

            <button 
                type="submit"
                class="w-full h-14 sm:h-16 bg-black text-white text-[15px] sm:text-[17px] font-semibold uppercase tracking-wider rounded-2xl hover:bg-gray-800 transition"
            >
                Create Account
            </button>

            <div class="text-center mt-8">
                <a href="{{ route('customer.login') }}" 
                   class="text-[15px] underline hover:text-black transition">
                    Already have an account? Login here
                </a>
            </div>
        </form>

    </div>

</div>
@endsection