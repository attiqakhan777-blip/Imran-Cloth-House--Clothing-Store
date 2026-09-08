
@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="min-h-screen bg-white">

    @php
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += (float) $item['price'] * (int) $item['quantity'];
        }

        $shipping = $subtotal >= 20000 ? 0 : ($setting->shipping_charges ?? 0);
        $tax = $setting->tax_charges ?? 0;
        $handling = $setting->handling_charges ?? 0;
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-2 min-h-screen">

        {{-- LEFT --}}
        <div class="px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 py-6 sm:py-8 lg:py-12 order-2 lg:order-1">

            <div class="w-full max-w-[650px] mx-auto lg:ml-auto">

                <form action="{{ route('checkout.placeOrder') }}" method="POST">
                    @csrf

                    <div class="mb-7 sm:mb-8">
                        <h2 class="text-xl sm:text-2xl font-semibold mb-4 sm:mb-5">Contact Information</h2>

                        <input type="email" name="email"
                               value="{{ auth()->check() ? auth()->user()->email : '' }}"
                               placeholder="Email Address"
                               class="w-full h-12 sm:h-14 border border-gray-300 rounded-xl px-4 sm:px-5 text-sm sm:text-base outline-none focus:border-blue-600"
                               required>
                    </div>

                    <div class="mb-7 sm:mb-8">
                        <h2 class="text-xl sm:text-2xl font-semibold mb-4 sm:mb-5">Delivery Information</h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mb-3 sm:mb-4">
                            <input type="text" name="first_name" placeholder="First Name"
                                   class="h-12 sm:h-14 border border-gray-300 rounded-xl px-4 sm:px-5 text-sm sm:text-base outline-none focus:border-blue-600">

                            <input type="text" name="last_name" placeholder="Last Name"
                                   class="h-12 sm:h-14 border border-gray-300 rounded-xl px-4 sm:px-5 text-sm sm:text-base outline-none focus:border-blue-600">
                        </div>

                        <input type="text" name="address" placeholder="Street Address"
                               class="w-full h-12 sm:h-14 border border-gray-300 rounded-xl px-4 sm:px-5 text-sm sm:text-base outline-none focus:border-blue-600 mb-3 sm:mb-4">

                        <input type="text" name="apartment" placeholder="Apartment, Suite, etc. (optional)"
                               class="w-full h-12 sm:h-14 border border-gray-300 rounded-xl px-4 sm:px-5 text-sm sm:text-base outline-none focus:border-blue-600 mb-3 sm:mb-4">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <input type="text" name="city" placeholder="City"
                                   class="h-12 sm:h-14 border border-gray-300 rounded-xl px-4 sm:px-5 text-sm sm:text-base outline-none focus:border-blue-600">

                            <input type="text" name="postal_code" placeholder="Postal Code (optional)"
                                   class="h-12 sm:h-14 border border-gray-300 rounded-xl px-4 sm:px-5 text-sm sm:text-base outline-none focus:border-blue-600">
                        </div>

                        <input type="text" name="phone" placeholder="Phone Number"
                               class="w-full h-12 sm:h-14 border border-gray-300 rounded-xl px-4 sm:px-5 text-sm sm:text-base outline-none focus:border-blue-600 mt-3 sm:mt-4">
                    </div>

                    <div class="mb-7 sm:mb-8">
                        <h2 class="text-xl sm:text-2xl font-semibold mb-4 sm:mb-5">Shipping Method</h2>

                        <label class="flex flex-col xs:flex-row sm:flex-row sm:items-center sm:justify-between gap-3 border-2 border-blue-600 bg-blue-50 rounded-2xl px-4 sm:px-5 py-4 sm:py-5 cursor-pointer">

                            <div class="flex items-center gap-3">
                                <input type="radio" checked name="shipping_method" value="Standard" class="w-5 h-5 flex-shrink-0">
                                <span class="text-sm sm:text-base">Standard Delivery</span>
                            </div>

                            @if($shipping == 0)
                                <span class="font-semibold text-green-600 text-sm sm:text-base whitespace-nowrap">
                                    FREE
                                </span>
                            @else
                                <span class="font-semibold text-sm sm:text-base whitespace-nowrap">
                                    Rs {{ number_format($shipping) }}
                                </span>
                            @endif
                        </label>

                        @if($subtotal >= 20000)
                            <div class="mt-3 p-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm font-medium">
                                🎉 Free shipping applied on orders PKR 20,000 or above.
                            </div>
                        @endif
                    </div>

                    <div class="mb-7 sm:mb-8">
                        <h2 class="text-xl sm:text-2xl font-semibold mb-4 sm:mb-5">Payment Method</h2>

                        <div class="border border-gray-300 rounded-2xl overflow-hidden">
                            <label class="flex items-center gap-3 px-4 sm:px-5 py-4 sm:py-5 border-b cursor-pointer bg-blue-50">
                                <input type="radio" checked name="payment_method" value="COD" class="w-5 h-5 flex-shrink-0">
                                <span class="text-sm sm:text-base">Cash on Delivery (COD)</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full h-13 sm:h-16 min-h-[52px] bg-blue-600 hover:bg-blue-700 text-white text-base sm:text-lg font-semibold rounded-2xl transition">
                        Place Order
                    </button>

                </form>

            </div>
        </div>

        {{-- RIGHT --}}
        <div class="bg-gray-50 px-4 sm:px-6 md:px-8 lg:px-12 xl:px-16 py-6 sm:py-8 lg:py-12 border-t lg:border-t-0 lg:border-l border-gray-200 order-1 lg:order-2">

            <div class="w-full max-w-[520px] mx-auto lg:mr-auto">

                <h2 class="text-xl sm:text-2xl font-semibold mb-6 sm:mb-8">
                    Order Summary
                </h2>

                @php
                    $couponData = $couponData ?? [];
                    $couponDiscount = (float) ($couponData['discount'] ?? 0);
                    $couponCode = $couponData['code'] ?? null;
                    $grandTotal = max(0, $subtotal + $shipping + $tax + $handling - $couponDiscount);
                @endphp

                <div class="space-y-5 sm:space-y-6">
                    @foreach($cart as $item)
                        @php
                            $lineTotal = (float) $item['price'] * (int) $item['quantity'];
                        @endphp

                        <div class="flex gap-3 sm:gap-4">
                            <div class="w-16 h-20 sm:w-20 sm:h-24 bg-white border border-gray-200 rounded-xl overflow-hidden flex-shrink-0">
                                <img src="{{ !empty($item['image']) ? asset($item['image']) : 'https://picsum.photos/300/400' }}"
                                     alt="{{ $item['name'] }}"
                                     class="w-full h-full object-cover">
                            </div>

                            <div class="flex-1 min-w-0">
                                <h3 class="font-medium leading-tight text-sm sm:text-base break-words">
                                    {{ $item['name'] }}
                                </h3>

                                @if(!empty($item['size']))
                                    <p class="text-xs sm:text-sm text-gray-500 mt-1">
                                        Size: {{ $item['size'] }}
                                    </p>
                                @endif

                                <p class="text-xs sm:text-sm text-gray-500">
                                    Qty: {{ $item['quantity'] }}
                                </p>
                            </div>

                            <div class="text-right font-medium text-sm sm:text-base whitespace-nowrap">
                                Rs {{ number_format($lineTotal) }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 sm:mt-10 pt-6 sm:pt-8 border-t border-gray-300 space-y-3 sm:space-y-4 text-sm sm:text-[15px]">
                    <div class="flex justify-between gap-4">
                        <span>Subtotal</span>
                        <span class="whitespace-nowrap">Rs {{ number_format($subtotal) }}</span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span>Shipping</span>

                        @if($shipping == 0)
                            <span class="text-green-600 font-semibold whitespace-nowrap">FREE</span>
                        @else
                            <span class="whitespace-nowrap">Rs {{ number_format($shipping) }}</span>
                        @endif
                    </div>

                    <div class="flex justify-between gap-4">
                        <span>Tax</span>
                        <span class="whitespace-nowrap">Rs {{ number_format($tax) }}</span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span>Handling</span>
                        <span class="whitespace-nowrap">Rs {{ number_format($handling) }}</span>
                    </div>

                    @if($couponDiscount > 0)
                        <div class="flex justify-between gap-4 text-green-700">
                            <span>Coupon ({{ $couponCode }})</span>
                            <span class="whitespace-nowrap">- Rs {{ number_format($couponDiscount) }}</span>
                        </div>
                    @endif
                </div>

                @if($subtotal >= 20000)
                    <div class="mt-4 p-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm font-medium">
                        🎉 Congratulations! You qualify for FREE SHIPPING.
                    </div>
                @endif

                <div class="mt-6 sm:mt-8 mb-4">
                    <h3 class="text-sm font-semibold uppercase tracking-wide mb-3">Coupon Code</h3>

                    @if(session('success'))
                        <div class="mb-3 p-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->has('coupon_code'))
                        <div class="mb-3 p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                            {{ $errors->first('coupon_code') }}
                        </div>
                    @endif

                    @if($couponCode)
                        <div class="flex items-center justify-between gap-3 border border-green-300 bg-green-50 rounded-xl px-4 py-3">
                            <div>
                                <p class="text-sm font-semibold text-green-800">Code: {{ $couponCode }}</p>
                                <p class="text-xs text-green-700">Discount: Rs {{ number_format($couponDiscount) }}</p>
                            </div>
                            <form action="{{ route('checkout.removeCoupon') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium">
                                    Remove
                                </button>
                            </form>
                        </div>
                    @else
                        <form action="{{ route('checkout.applyCoupon') }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="text" name="coupon_code" maxlength="6" pattern="[0-9]{6}"
                                   placeholder="6 digit code"
                                   class="flex-1 h-12 border border-gray-300 rounded-xl px-4 text-sm outline-none focus:border-blue-600 font-mono tracking-widest"
                                   required>
                            <button type="submit"
                                    class="h-12 px-5 bg-black text-white rounded-xl text-sm font-semibold hover:bg-gray-800">
                                Apply
                            </button>
                        </form>
                        <p class="text-xs text-gray-500 mt-2">Not valid on sale items. One-time use only.</p>
                    @endif
                </div>

                <div class="pt-6 sm:pt-8 border-t border-gray-300 flex justify-between gap-4 text-lg sm:text-xl font-bold">
                    <span>Total</span>
                    <span class="whitespace-nowrap">
                        Rs {{ number_format($grandTotal) }}
                    </span>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection