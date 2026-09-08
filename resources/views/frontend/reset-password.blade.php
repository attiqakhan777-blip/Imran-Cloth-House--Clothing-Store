@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen bg-white flex items-center justify-center py-8 px-4 sm:px-6">

    <div class="w-full max-w-[480px]">

        <div class="text-center mb-10">
            <h1 class="text-3xl sm:text-4xl font-bold uppercase tracking-wide text-slate-800">
                Reset Password
            </h1>
            <p class="text-gray-600 mt-4 text-[15px] sm:text-[17px]">
                Enter your new password
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

        <form method="POST" action="{{ route('reset.password') }}">
            @csrf

            <div class="mb-6">
                <label class="block text-[16px] sm:text-[17px] font-medium mb-3 text-gray-700">
                    New Password <span class="text-red-500">*</span>
                </label>
                <input 
                    type="password" 
                    name="password" 
                    required
                    minlength="6"
                    class="w-full h-14 sm:h-[70px] border border-gray-300 px-5 text-base sm:text-[17px] rounded-2xl outline-none focus:border-black transition"
                    placeholder="••••••••"
                >
            </div>

            <div class="mb-8">
                <label class="block text-[16px] sm:text-[17px] font-medium mb-3 text-gray-700">
                    Confirm New Password <span class="text-red-500">*</span>
                </label>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    required
                    class="w-full h-14 sm:h-[70px] border border-gray-300 px-5 text-base sm:text-[17px] rounded-2xl outline-none focus:border-black transition"
                    placeholder="••••••••"
                >
            </div>

            <button 
                type="submit"
                class="w-full h-14 sm:h-[58px] bg-[#222] text-white text-[16px] sm:text-[17px] font-semibold uppercase tracking-wider rounded-2xl hover:bg-gray-800 transition"
            >
                Reset Password
            </button>
        </form>

    </div>

</div>
@endsection