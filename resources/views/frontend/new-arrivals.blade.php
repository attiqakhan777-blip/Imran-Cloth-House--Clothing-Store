
text/x-generic new-arrivals.blade.php ( HTML document, ASCII text, with CRLF line terminators )
@extends('layouts.app')

@section('title', 'New Arrivals')

@section('content')
<div class="max-w-7xl mx-auto px-6 pt-8 flex gap-10">

    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1">
        
        <!-- Filter Buttons -->
        <div class="flex flex-wrap gap-3 mb-8">
            <a href="{{ route('frontend.women') }}" 
               class="px-5 py-2 border border-gray-300 rounded-xl text-sm hover:bg-gray-50 transition">
                Women
            </a>
            <a href="{{ route('frontend.men') }}" 
               class="px-5 py-2 border border-gray-300 rounded-xl text-sm hover:bg-gray-50 transition">
                Men
            </a>
            <a href="{{ route('frontend.kids') }}" 
               class="px-5 py-2 border border-gray-300 rounded-xl text-sm hover:bg-gray-50 transition">
                Kids
            </a>
            <a href="{{ route('frontend.wedding') }}" 
               class="px-5 py-2 border border-gray-300 rounded-xl text-sm hover:bg-gray-50 transition">
                Wedding
            </a>
        </div>

        <div class="flex justify-between items-center border-b pb-3 mb-6">
            <h1 class="text-2xl font-bold">NEW ARRIVALS</h1>
            
            <button onclick="toggleSort()" 
                    class="flex items-center gap-2 border border-gray-300 px-5 py-2 rounded-xl text-sm">
                NEWEST <i class="fa-solid fa-chevron-down text-xs"></i>
            </button>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
            @if($products->isEmpty())
                <div class="col-span-full py-20 text-center text-gray-500">
                    No new arrivals found.
                </div>
            @else
                @foreach($products as $product)
                    <a href="{{ route('product.detail', $product->slug ?? $product->id) }}" 
                       class="product-card block border border-gray-200 rounded-2xl overflow-hidden hover:shadow-xl transition">
                        
                        <div class="relative aspect-[4/5] bg-gray-100">
                            <img src="{{ $product->images && count($product->images) > 0 ? asset($product->images[0]) : 'https://picsum.photos/id/301/800/1000' }}" 
                                 class="w-full h-full object-cover" alt="{{ $product->name }}">

                            <!-- Discount Badge -->
                            @if($product->discount_percentage > 0)
                                <div class="absolute top-4 right-4 bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                                    -{{ $product->discount_percentage }}%
                                </div>
                            @endif
                        </div>

                        <div class="p-4">
                            <!-- Price Section with Discount -->
                            <div class="flex items-baseline gap-2">
                                @if($product->discount_price && $product->discount_percentage > 0)
                                    <span class="font-semibold text-xl text-orange-600">
                                        Rs. {{ number_format($product->discount_price) }}
                                    </span>
                                    <span class="text-sm text-gray-400 line-through">
                                        Rs. {{ number_format($product->price) }}
                                    </span>
                                @else
                                    <span class="font-semibold text-xl">
                                        Rs. {{ number_format($product->price) }}
                                    </span>
                                @endif
                            </div>
                            
                            <p class="text-sm text-gray-600 line-clamp-2 mt-1">{{ $product->name }}</p>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>

        <!-- Pagination -->
        <div class="mt-10 flex justify-center">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection