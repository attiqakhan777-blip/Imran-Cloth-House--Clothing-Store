@extends('layouts.admin')

@section('title', 'Edit Coupon')

@section('content')
<div class="p-6">
    <div class="max-w-2xl mx-auto">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Edit Coupon</h1>
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

        @if($coupon->is_used)
            <div class="bg-yellow-50 border border-yellow-300 text-yellow-800 px-6 py-4 rounded-2xl mb-6 text-sm">
                This coupon has already been used{{ $coupon->used_at ? ' on ' . $coupon->used_at->format('d M Y, h:i A') : '' }}.
            </div>
        @endif

        <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST" class="bg-white rounded-3xl p-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Coupon Code (6 digits) <span class="text-red-500">*</span></label>
                    <input type="text" name="code" value="{{ old('code', $coupon->code) }}" maxlength="6" pattern="[0-9]{6}"
                           class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:outline-none focus:border-orange-500 font-mono tracking-widest"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Discount Amount (Rs) <span class="text-red-500">*</span></label>
                    <input type="number" name="discount_amount" value="{{ old('discount_amount', $coupon->discount_amount) }}" min="1" step="1"
                           class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:outline-none focus:border-orange-500"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Status</label>
                    <select name="is_active" class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                        <option value="1" @selected(old('is_active', $coupon->is_active) == 1)>Active</option>
                        <option value="0" @selected(old('is_active', $coupon->is_active) == 0)>Inactive</option>
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
                    Update Coupon
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
