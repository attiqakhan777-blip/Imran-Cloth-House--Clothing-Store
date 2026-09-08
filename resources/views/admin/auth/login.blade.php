@extends('layouts.guest')   {{-- We'll create this simple layout below --}}

@section('title', 'Admin Login')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-xl p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold">Imran Cloth House</h1>
            <p class="text-gray-500 mt-1">Admin Panel</p>
        </div>

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input type="email" name="email" 
                       class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:outline-none focus:border-amber-500"
                       placeholder="admin@libaaslegacy.com" required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" name="password" 
                       class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:outline-none focus:border-amber-500"
                       placeholder="••••••••" required>
            </div>

            <button type="submit"
                    class="w-full bg-black text-white py-4 rounded-2xl font-semibold hover:bg-gray-800 transition">
                Login to Admin Panel
            </button>
        </form>

        <div class="text-center mt-6">
           <a href="{{ route('admin.password.request') }}" class="text-amber-600 text-sm hover:underline">
    Forgot Password?
</a>
        </div>
    </div>
</div>
@endsection