@extends('layouts.admin')

@section('title', 'Coupons')

@section('content')
<div class="p-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Coupons / Vouchers</h1>
            <a href="{{ route('admin.coupons.create') }}"
               class="px-6 py-3 bg-orange-500 text-white rounded-2xl hover:bg-orange-600 transition">
                + Add Coupon
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-2xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left">Code</th>
                        <th class="px-6 py-4 text-left">Discount (Rs)</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Usage</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($coupons as $coupon)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-mono font-semibold tracking-widest">{{ $coupon->code }}</td>
                            <td class="px-6 py-4">Rs {{ number_format($coupon->discount_amount) }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($coupon->is_active)
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">Active</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-medium">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($coupon->is_used)
                                    <span class="bg-gray-200 text-gray-700 px-3 py-1 rounded-full text-xs font-medium">Used</span>
                                @else
                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-medium">Available</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.coupons.edit', $coupon) }}"
                                   class="text-blue-600 hover:text-blue-800 mr-4">Edit</a>
                                <form action="{{ route('admin.coupons.destroy', $coupon) }}"
                                      method="POST" class="inline"
                                      onsubmit="return confirm('Delete this coupon?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                No coupons found.
                                <a href="{{ route('admin.coupons.create') }}" class="text-orange-500">Create one now</a>
                            </td>
                        </tr>
                    @endempty
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
