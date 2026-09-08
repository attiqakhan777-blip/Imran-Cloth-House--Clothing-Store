@extends('layouts.app')

@section('title', 'Order Success')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-8 px-4 sm:px-6">

    <div class="bg-white rounded-3xl shadow-xl p-6 sm:p-10 max-w-md w-full text-center">

        <!-- Success Icon -->
        <div class="mx-auto w-20 h-20 sm:w-24 sm:h-24 bg-green-100 rounded-full flex items-center justify-center mb-6">
            <i class="fa-solid fa-check text-5xl sm:text-6xl text-green-600"></i>
        </div>

        <h1 class="text-2xl sm:text-3xl font-bold text-green-600 mb-3">
            Order Placed Successfully!
        </h1>

        <p class="text-gray-600 text-[15px] sm:text-base leading-relaxed">
            Thank you for your purchase. Your order has been received and is being processed.
        </p>

        @if(isset($order) && $order)
            <div class="mt-8 bg-gray-50 border border-gray-100 rounded-2xl p-5 text-left text-sm">

                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Order Number</span>
                    <span class="font-medium">{{ $order->order_number ?? 'N/A' }}</span>
                </div>

                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Tracking Number</span>
                    <span class="font-medium">{{ $order->tracking_number ?? 'N/A' }}</span>
                </div>

                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Status</span>
                    <span class="font-medium capitalize">{{ $order->status ?? 'Pending' }}</span>
                </div>

                <div class="flex justify-between py-2">
    <span class="text-gray-600">Total Amount</span>
    <span class="font-bold text-lg text-green-600">
        Rs. {{ number_format($order->total ?? 0, 2) }}
    </span>
</div>

            </div>
        @else
            <p class="text-red-500 mt-6 text-sm">
                Order details not found.
            </p>
        @endif

        <div class="mt-10 space-y-3">
            <a href="{{ route('home') }}" 
               class="block w-full bg-black text-white py-4 rounded-2xl font-semibold hover:bg-gray-800 transition">
                Continue Shopping
            </a>
        </div>

    </div>

</div>
@endsection