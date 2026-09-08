@extends('layouts.guest')

@section('title', 'Reset Admin Password')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl p-8">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold">Reset Password</h1>
            <p class="text-gray-500 mt-2">Create your new admin password</p>
        </div>

        @if($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-xl text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.password.update') }}">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    New Password
                </label>

                <input type="password"
                       name="password"
                       class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:outline-none focus:border-amber-500"
                       placeholder="New password"
                       required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Confirm Password
                </label>

                <input type="password"
                       name="password_confirmation"
                       class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:outline-none focus:border-amber-500"
                       placeholder="Confirm password"
                       required>
            </div>

            <button type="submit"
                    class="w-full bg-black text-white py-4 rounded-2xl font-semibold hover:bg-gray-800 transition">
                Update Password
            </button>
        </form>

    </div>
</div>
@endsection