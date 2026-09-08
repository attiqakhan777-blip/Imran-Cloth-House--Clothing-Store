@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="min-h-screen bg-white py-8 sm:py-12">

    <div class="max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-8">

        <h1 class="text-2xl sm:text-3xl font-bold uppercase tracking-wide mb-8 sm:mb-10">My Orders</h1>

        @if($orders->isEmpty())
            <div class="text-center py-20 bg-gray-50 rounded-3xl">
                <i class="fa-solid fa-box text-8xl text-gray-200 mb-6"></i>
                <h3 class="text-2xl font-medium text-gray-700">No Orders Yet</h3>
                <p class="text-gray-500 mt-3">When you place an order, it will appear here.</p>
                <a href="{{ route('home') }}" 
                   class="mt-8 inline-block bg-black text-white px-10 py-4 rounded-2xl hover:bg-gray-800 transition">
                    Start Shopping
                </a>
            </div>
        @else
            <div class="space-y-6 sm:space-y-8">
                @foreach($orders as $order)
                <div class="border border-gray-200 rounded-2xl p-5 sm:p-6 hover:shadow-md transition">

                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                        <div>
                            <p class="text-xs sm:text-sm text-gray-500">
                                Order #{{ $order->order_number ?? $order->id }}
                            </p>
                            <p class="text-lg sm:text-xl font-semibold mt-1">
                                Rs. {{ number_format($order->total ?? 0) }}
                            </p>
                        </div>

                        <div class="text-left sm:text-right">
                            <span class="inline-block px-4 py-1.5 text-xs sm:text-sm font-medium rounded-full
                                @if($order->status == 'delivered') bg-green-100 text-green-700
                                @elseif($order->status == 'pending') bg-yellow-100 text-yellow-700
                                @elseif($order->status == 'returned') bg-red-100 text-red-700
                                @else bg-gray-100 text-gray-700 @endif">
                                {{ ucfirst($order->status ?? 'pending') }}
                            </span>
                            <p class="text-xs text-gray-500 mt-2">
                                {{ $order->created_at->format('d M, Y') }}
                            </p>
                        </div>
                    </div>

                    {{-- Order Items --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($order->items as $item)
                            <div class="flex gap-3">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="{{ asset('storage/' . ($item->product->images[0] ?? $item->product->image ?? '')) }}" 
                                         alt="{{ $item->product->name ?? '' }}" 
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="text-xs sm:text-sm">
                                    <p class="font-medium line-clamp-2 leading-tight">
                                        {{ $item->product->name ?? 'Product' }}
                                    </p>
                                    <p class="text-gray-500 mt-1">Qty: {{ $item->quantity }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a href="#" 
                       class="mt-6 inline-block text-black underline text-sm hover:text-gray-600 transition">
                        View Order Details →
                    </a>
                </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection