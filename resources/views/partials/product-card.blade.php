<a 
    href="{{ route('product.detail', $product->slug ?? $product->id) }}"
    class="group block bg-white border border-gray-200 rounded-xl sm:rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-lg"
>
    {{-- Product Image --}}
    <div class="relative bg-gray-100 overflow-hidden">
        <img 
            src="{{ asset($product->images[0] ?? 'https://via.placeholder.com/400') }}" 
            alt="{{ $product->name }}" 
            class="w-full h-[210px] sm:h-[260px] md:h-[300px] lg:h-[320px] object-cover transition-transform duration-500 group-hover:scale-105"
        >

        {{-- Badge --}}
        @if($product->discount_price && $product->discount_percentage > 0)
            <div class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-red-600 text-white text-[10px] sm:text-xs font-semibold px-2.5 sm:px-3 py-1 rounded-sm shadow">
                Sale
            </div>

            <div class="absolute top-2 right-2 sm:top-3 sm:right-3 bg-white text-red-600 text-[10px] sm:text-xs font-bold px-2.5 sm:px-3 py-1 rounded-sm shadow">
                -{{ $product->discount_percentage }}%
            </div>
        @else
            <div class="absolute top-2 left-2 sm:top-3 sm:left-3 bg-white text-black text-[11px] sm:text-xs font-medium px-2.5 sm:px-3 py-1 rounded-sm shadow">
                New
            </div>
        @endif
    </div>

    {{-- Product Info --}}
    <div class="p-3 sm:p-4">

        {{-- Product Name --}}
        <h3 class="text-[13px] sm:text-[14px] md:text-[15px] font-medium text-gray-900 leading-5 line-clamp-2 min-h-[40px]">
            {{ $product->name }}
        </h3>

        {{-- Category --}}
        <p class="text-[11px] sm:text-xs text-gray-500 mt-1">
            {{ $product->category }}
        </p>

        {{-- Price --}}
        <div class="mt-3 flex items-center gap-2 flex-wrap">
            @if($product->discount_price && $product->discount_percentage > 0)
                <span class="text-[15px] sm:text-[17px] md:text-[18px] font-bold text-red-600">
                    Rs. {{ number_format($product->discount_price) }}
                </span>

                <span class="text-[12px] sm:text-sm text-gray-400 line-through">
                    Rs. {{ number_format($product->price) }}
                </span>
            @else
                <span class="text-[15px] sm:text-[17px] md:text-[18px] font-bold text-black">
                    Rs. {{ number_format($product->price) }}
                </span>
            @endif
        </div>
    </div>
</a>