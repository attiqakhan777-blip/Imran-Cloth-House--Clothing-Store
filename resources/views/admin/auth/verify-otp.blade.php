@extends('layouts.guest')

@section('title', 'Verify OTP')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl p-8">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold">Verify OTP</h1>
            <p class="text-gray-500 mt-2">Enter the 6 digit code sent to your email</p>
        </div>

        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-xl text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.otp.verify') }}">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    OTP Code
                </label>

                <input type="text"
                       name="otp"
                       maxlength="6"
                       class="w-full border border-gray-300 rounded-2xl px-5 py-4 text-center text-2xl tracking-widest focus:outline-none focus:border-amber-500"
                       placeholder="000000"
                       required>
            </div>

            <button type="submit"
                    class="w-full bg-black text-white py-4 rounded-2xl font-semibold hover:bg-gray-800 transition">
                Verify OTP
            </button>
        </form>

    </div>
</div>
@endsection