@extends('layouts.app')

@section('title', 'Big Sale - Up to 70% Off')

@section('content')
<div class="max-w-7xl mx-auto px-6 pt-8 flex gap-10">

    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1">
        
        <div class="flex justify-between items-center border-b pb-3 mb-6">
            <h1 class="text-2xl font-bold text-red-600">🔥 BIG SALE</h1>
            
            <button onclick="toggleSort()" 
                    class="flex items-center gap-2 border border-gray-300 px-5 py-2 rounded-xl text-sm">
                NEWEST <i class="fa-solid fa-chevron-down text-xs"></i>
            </button>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
            @if($saleProducts->isEmpty())
                <div class="col-span-full py-20 text-center text-gray-500">
                    No products on sale right now.
                </div>
            @else
                @foreach($saleProducts as $product)
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
                            <!-- Price Section -->
                            <div class="flex items-baseline gap-2">
                                <span class="text-xl font-bold text-orange-600">
                                    Rs. {{ number_format($product->discount_price) }}
                                </span>
                                @if($product->discount_percentage > 0)
                                    <span class="text-sm text-gray-400 line-through">
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

    </div>
</div>

<script>
    console.log("{{ $saleProducts->count() }} sale products loaded");
</script>
@endsection