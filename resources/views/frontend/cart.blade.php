
text/x-generic cart.blade.php ( HTML document, UTF-8 Unicode text, with CRLF line terminators )
@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')

<div class="w-full px-[15px] py-6 sm:py-10 overflow-hidden">

    {{-- Breadcrumb --}}
    <div class="text-xs sm:text-sm text-gray-700 mb-6 sm:mb-8">
        <a href="{{ route('home') }}" class="hover:underline">Home</a>
        <span class="mx-2">›</span>
        <span>Your Cart</span>
    </div>

    {{-- Heading --}}
    <h1 class="text-[22px] sm:text-[28px] lg:text-[32px] font-bold uppercase tracking-wide text-slate-900 mb-6 sm:mb-10">
        Your Cart
    </h1>

    @if(session('success'))
        <div class="mb-5 p-3 bg-green-100 text-green-700 text-sm rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-5 p-3 bg-red-100 text-red-700 text-sm rounded-xl">
            {{ $errors->first() }}
        </div>
    @endif

    @if(empty($cart))

        <div class="border border-gray-200 p-8 sm:p-14 text-center rounded-2xl">
            <h2 class="text-lg sm:text-xl font-bold mb-4">
                Your cart is empty
            </h2>

            <a href="{{ route('home') }}"
               class="inline-flex items-center justify-center bg-[#222] text-white px-7 py-3 text-sm uppercase tracking-wide rounded-xl">
                Continue Shopping
            </a>
        </div>

    @else

        @php $subtotal = 0; @endphp

        <div class="grid grid-cols-1 xl:grid-cols-[1fr_360px] gap-8 xl:gap-10">

            {{-- Cart Items --}}
            <div class="space-y-5">

             <div class="hidden lg:grid grid-cols-[2.5fr_1fr_1fr_1fr_60px] bg-gray-50 px-6 py-5 text-xs font-bold uppercase tracking-wider text-gray-600 rounded-t-2xl">
    <div>Product</div>
    <div class="text-center">Price</div>
    <div class="text-center">Quantity</div>
    <div class="text-center">Total</div>
    <div></div>
</div>

                @foreach($cart as $cartKey => $item)

                    @php
                        $lineTotal = (float) $item['price'] * (int) $item['quantity'];
                        $subtotal += $lineTotal;
                    @endphp

                    <div class="border border-gray-200 rounded-2xl p-5 bg-white">

    <div class="grid grid-cols-1 lg:grid-cols-[2.5fr_1fr_1fr_1fr_60px] items-center gap-6">

        {{-- Product --}}
        <div class="flex gap-4">

            <div class="w-[110px] h-[130px] bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                <img
                    src="{{ !empty($item['image']) ? asset($item['image']) : 'https://picsum.photos/300/400' }}"
                    alt="{{ $item['name'] }}"
                    class="w-full h-full object-cover"
                >
            </div>

            <div>
                <h3 class="font-semibold text-[16px]">
                    {{ $item['name'] }}
                </h3>

                @if(!empty($item['size']))
                    <p class="text-sm text-gray-500 mt-1">
                        Size: {{ $item['size'] }}
                    </p>
                @endif
            </div>

        </div>

        {{-- Price --}}
        <div class="hidden lg:flex justify-center font-medium">
            Rs. {{ number_format($item['price']) }}
        </div>

        {{-- Quantity --}}
        <div class="flex justify-center">

           <form method="POST"
      action="{{ route('cart.update', $cartKey) }}"
      class="inline-flex">
    @csrf

    <div class="flex border border-gray-300 rounded-xl overflow-hidden">

        <button type="button"
                onclick="decreaseQty(this)"
                class="w-9 h-10 flex items-center justify-center text-lg">
            -
        </button>

        <input type="number"
               name="quantity"
               value="{{ $item['quantity'] }}"
               min="1"
               class="w-14 text-center outline-none text-sm">

        <button type="button"
                onclick="increaseQty(this)"
                class="w-9 h-10 flex items-center justify-center text-lg">
            +
        </button>

    </div>

</form>

        </div>

        {{-- Total --}}
        <div class="hidden lg:flex justify-center font-semibold">
            Rs. {{ number_format($lineTotal) }}
        </div>

        {{-- Remove --}}
        <div class="flex justify-center">
            <form method="POST"
                  action="{{ route('cart.remove', $cartKey) }}">
                @csrf

                <button type="submit"
                        class="text-2xl text-gray-400 hover:text-red-600">
                    ×
                </button>
            </form>
        </div>

    </div>

</div>

                @endforeach

            </div>

            {{-- Order Summary --}}
            <div>

                <div class="xl:sticky xl:top-28 bg-white border border-gray-200 rounded-2xl p-5 sm:p-7">

                    <h2 class="uppercase text-xs font-bold tracking-widest mb-6">
                        Order Summary
                    </h2>

                    <div class="flex justify-between text-base sm:text-lg mb-4">
                        <span>Subtotal</span>
                        <span class="font-bold">
                            Rs. {{ number_format($subtotal) }}
                        </span>
                    </div>

                    <div class="border-t pt-5 mt-4">

                        <div class="flex justify-between text-lg sm:text-xl font-bold">
                            <span>Total</span>
                            <span>
                                Rs. {{ number_format($subtotal) }}
                            </span>
                        </div>

                        <p class="text-xs text-gray-500 mt-2">
                            Including all taxes
                        </p>

                    </div>

                    <a href="{{ route('checkout') }}"
                       class="mt-7 block w-full bg-black text-white py-4 text-center rounded-xl font-semibold hover:bg-gray-800 transition">
                        Proceed To Checkout
                    </a>

                    <a href="{{ route('home') }}"
                       class="mt-4 block w-full border border-gray-400 py-4 text-center rounded-xl font-semibold hover:bg-gray-50 transition">
                        Continue Shopping
                    </a>

                </div>

            </div>

        </div>

    @endif

    {{-- Previous Orders --}}
    @if(isset($previousOrders) && $previousOrders->count())

        <div class="mt-12 sm:mt-16">

            <h2 class="text-xl sm:text-2xl font-bold mb-6 uppercase tracking-wide text-slate-900">
                Previous Orders
            </h2>

            <div class="space-y-5">

                @foreach($previousOrders as $order)

                    <div class="border border-gray-200 rounded-2xl p-4 sm:p-5 bg-white">

                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                            <div>

                                <h3 class="font-bold text-lg">
                                    {{ $order->order_number }}
                                </h3>


                                <div class="mt-3">

                                    @if($order->status == 'Pending')
                                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            Pending
                                        </span>

                                    @elseif($order->status == 'Delivered')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            Delivered
                                        </span>

                                    @elseif($order->status == 'Returned')
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                            Returned
                                        </span>
                                    @endif

                                </div>

                            </div>

                            <div class="lg:text-right">

                                <div class="text-xl font-bold mb-3">
                                    Rs. {{ number_format($order->total_amount) }}
                                </div>

                                

                            </div>

                        </div>

                        @if($order->items && $order->items->count())

                            <div class="mt-5 border-t pt-5">

                                <div class="flex flex-wrap gap-4">

                                    @foreach($order->items as $item)

                                        <div class="flex items-center gap-3 border rounded-xl p-3 bg-white w-full sm:w-auto sm:min-w-[260px]">

                                           

                                            <div class="min-w-0">

                                                <h4 class="font-medium text-sm truncate">
                                                    {{ $item->product_name }}
                                                </h4>

                                                @if($item->size)
                                                    <p class="text-xs text-gray-500">
                                                        Size: {{ $item->size }}
                                                    </p>
                                                @endif

                                                <p class="text-xs text-gray-500">
                                                    Qty: {{ $item->quantity }}
                                                </p>

                                                <p class="text-xs text-gray-500">
                                                      Rs. {{ number_format($order->total_amount) }}
                                                </p>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        @endif

                    </div>

                @endforeach

            </div>

        </div>

    @endif

</div>

<script>
function increaseQty(btn) {
    let form = btn.closest('form');
    let input = form.querySelector('input[name="quantity"]');

    input.value = parseInt(input.value) + 1;

    form.submit();
}

function decreaseQty(btn) {
    let form = btn.closest('form');
    let input = form.querySelector('input[name="quantity"]');

    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
        form.submit();
    }
}
</script>

@endsection