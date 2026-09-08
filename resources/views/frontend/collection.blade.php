
text/x-generic collection.blade.php ( HTML document, ASCII text, with CRLF line terminators )
@extends('layouts.app')

@section('title', $title ?? $category->name ?? 'Collection')

@section('content')

<div class="max-w-[1500px] mx-auto px-3 sm:px-5 lg:px-8 pt-3 sm:pt-4 lg:pt-8">

    <div class="border-t border-gray-200">

        <div class="flex flex-col lg:flex-row">

            {{-- Desktop Sidebar Only --}}
            <div class="hidden lg:block w-[260px] shrink-0 border-r border-gray-200 pt-16 pr-8">
                @include('partials.sidebar')
            </div>

            {{-- Main Content --}}
            <div class="flex-1 pt-4 sm:pt-5 lg:pl-10 xl:pl-20">

                {{-- Page Header --}}
                <div class="border-b border-gray-200 pb-4 mb-5 lg:mb-6">
                    <h1 class="text-[20px] sm:text-[24px] lg:text-[25px] uppercase tracking-wide font-bold text-slate-800 break-words">
                        {{ $title ?? $category->name ?? 'Collection' }}
                    </h1>
                </div>

                {{-- Sort Dropdown --}}
                <div class="relative mb-5 sm:mb-6 lg:mb-8">
                    <button
                        type="button"
                        onclick="toggleSortDropdown()"
                        class="w-full sm:w-[200px] h-[46px] sm:h-[48px] flex items-center justify-between border border-gray-300 rounded-xl px-4 sm:px-5 text-[12px] sm:text-[13px] font-bold text-black bg-white"
                    >
                        <span class="truncate">
                            @if(request('sort') === 'price-low')
                                PRICE LOW TO HIGH
                            @elseif(request('sort') === 'price-high')
                                PRICE HIGH TO LOW
                            @else
                                NEWEST
                            @endif
                        </span>

                        <i class="fa-solid fa-sliders text-xs flex-shrink-0"></i>
                    </button>

                    <div
                        id="sortDropdown"
                        class="hidden absolute left-0 top-full mt-2 w-full sm:w-[230px] bg-white border border-gray-200 rounded-xl shadow-lg z-50 overflow-hidden"
                    >
                        <a
                            href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}"
                            class="block px-5 py-3 text-[13px] sm:text-[14px] text-gray-700 hover:bg-gray-100 {{ request('sort', 'newest') === 'newest' ? 'font-bold text-black bg-gray-50' : '' }}"
                        >
                            Newest
                        </a>

                        <a
                            href="{{ request()->fullUrlWithQuery(['sort' => 'price-low']) }}"
                            class="block px-5 py-3 text-[13px] sm:text-[14px] text-gray-700 hover:bg-gray-100 {{ request('sort') === 'price-low' ? 'font-bold text-black bg-gray-50' : '' }}"
                        >
                            Price Low to High
                        </a>

                        <a
                            href="{{ request()->fullUrlWithQuery(['sort' => 'price-high']) }}"
                            class="block px-5 py-3 text-[13px] sm:text-[14px] text-gray-700 hover:bg-gray-100 {{ request('sort') === 'price-high' ? 'font-bold text-black bg-gray-50' : '' }}"
                        >
                            Price High to Low
                        </a>
                    </div>
                </div>

                <script>
                    function toggleSortDropdown() {
                        document.getElementById('sortDropdown')?.classList.toggle('hidden');
                    }

                    document.addEventListener('click', function(event) {
                        const dropdown = document.getElementById('sortDropdown');
                        const sortButton = event.target.closest('button[onclick="toggleSortDropdown()"]');

                        if (!event.target.closest('#sortDropdown') && !sortButton) {
                            dropdown?.classList.add('hidden');
                        }
                    });
                </script>

                {{-- Product Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-x-3 sm:gap-x-4 lg:gap-x-5 gap-y-6 sm:gap-y-7 lg:gap-y-9">

                    @if($products->isEmpty())

                        <div class="col-span-full py-16 sm:py-20 text-center text-gray-500 text-sm sm:text-base">
                            No products found in
                            <strong>{{ $title ?? 'this collection' }}</strong>.
                        </div>

                    @else

                        @foreach($products as $product)

                            @php
                                $isSalePage = request()->route('slug') === 'sale'
                                    || str_starts_with(strtolower($title ?? ''), 'sale');

                                $hasDiscount =
                                    !empty($product->discount_price) &&
                                    $product->discount_price > 0 &&
                                    $product->discount_price < $product->price;

                                $isSaleProduct = $isSalePage || $hasDiscount || ($product->discount_percentage ?? 0) > 0;
                            @endphp

                            <a
                                href="{{ route('product.detail', $product->slug ?? $product->id) }}"
                                class="block border border-gray-200 rounded-lg overflow-hidden bg-white hover:shadow-sm transition"
                            >

                                {{-- Product Image --}}
                                <div class="relative aspect-[3/4] bg-gray-100 overflow-hidden border-b border-gray-200">

                                    <img
                                        src="{{ $product->images && count($product->images) > 0 ? asset($product->images[0]) : 'https://picsum.photos/id/301/800/1000' }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-full object-cover"
                                        loading="lazy"
                                        decoding="async"
                                    >
@if(($product->stock ?? 0) <= 0)
    <div class="absolute top-0 right-0 z-10">
        <span class="block bg-gray-700 text-white text-[8px] sm:text-[10px] font-semibold px-3 py-1 uppercase tracking-wider">
            SOLD OUT
        </span>
    </div>
@endif
                                    @if($isSaleProduct)
                                        <div class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-red-600 text-white text-[10px] sm:text-[11px] px-2 sm:px-3 py-1 rounded-sm">
                                            Sale
                                        </div>
                                    @else
                                        <div class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-white text-black text-[10px] sm:text-[13px] px-2 sm:px-3 py-1 border border-gray-200">
                                            New
                                        </div>
                                    @endif

                                </div>

                                {{-- Product Info --}}
                                <div class="p-2.5 sm:p-3">

                                    <div class="flex items-center gap-1 sm:gap-2 flex-wrap">
                                        @if($hasDiscount)

                                            <span class="font-bold text-[13px] sm:text-[16px] lg:text-[17px] leading-none text-red-600">
                                                Rs.{{ number_format($product->discount_price) }}.00
                                            </span>

                                            <span class="text-[10px] sm:text-[13px] text-gray-400 line-through">
                                                Rs.{{ number_format($product->price) }}.00
                                            </span>

                                        @else

                                            <span class="font-bold text-[13px] sm:text-[16px] lg:text-[17px] leading-none text-black">
                                                Rs.{{ number_format($product->price) }}.00
                                            </span>

                                        @endif
                                    </div>

                                    <p class="text-[11px] sm:text-[12px] lg:text-[13px] leading-4 sm:leading-5 font-normal text-black mt-2 line-clamp-2 break-words">
                                        {{ $product->name }}
                                    </p>

                                </div>

                            </a>

                        @endforeach

                    @endif

                </div>

                {{-- Pagination --}}
                <div class="mt-8 sm:mt-10 lg:mt-12 flex justify-center overflow-x-auto pb-4">
                    {{ $products->links() }}
                </div>

            </div>

        </div>

    </div>

</div>

@endsection