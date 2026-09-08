@extends('layouts.admin')

@section('title', 'Create Coupon')

@section('content')
<div class="p-6">
    <div class="max-w-2xl mx-auto">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Create Coupon</h1>
            <a href="{{ route('admin.coupons.index') }}" class="text-gray-500 hover:text-black">← Back</a>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-2xl mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.coupons.store') }}" method="POST" class="bg-white rounded-3xl p-8">
            @csrf

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Coupon Code (6 digits) <span class="text-red-500">*</span></label>
                    <input type="text" name="code" value="{{ old('code') }}" maxlength="6" pattern="[0-9]{6}"
                           class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:outline-none focus:border-orange-500 font-mono tracking-widest"
                           placeholder="e.g. 123456" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Discount Amount (Rs) <span class="text-red-500">*</span></label>
                    <input type="number" name="discount_amount" value="{{ old('discount_amount') }}" min="1" step="1"
                           class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:outline-none focus:border-orange-500"
                           placeholder="e.g. 500" required>
                    <p class="text-xs text-gray-500 mt-2">One-time use. Not applicable on sale items.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Status</label>
                    <select name="is_active" class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                        <option value="1" selected>Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-10">
                <a href="{{ route('admin.coupons.index') }}"
                   class="px-8 py-4 border border-gray-300 rounded-2xl hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit"
                        class="px-10 py-4 bg-orange-500 text-white rounded-2xl hover:bg-orange-600 transition">
                    Create Coupon
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
