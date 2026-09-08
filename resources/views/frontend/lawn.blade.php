@extends('layouts.app')

@section('title', 'Lawn Collection')

@section('content')
<div class="max-w-7xl mx-auto px-6 pt-8 flex gap-10">

    @include('partials.sidebar')

    <div class="flex-1">
        <div class="flex justify-between items-center border-b pb-3 mb-6">
            <h1 class="text-2xl font-bold">LAWN COLLECTION</h1>
            
            <button onclick="toggleSort()" 
                    class="flex items-center gap-2 border border-gray-300 px-5 py-2 rounded-xl text-sm">
                NEWEST <i class="fa-solid fa-chevron-down text-xs"></i>
            </button>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
            @if($products->isEmpty())
                <div class="col-span-full py-20 text-center text-gray-500">
                    No Lawn products found.
                </div>
            @else
                @foreach($products as $product)
                    <a href="{{ route('product.detail', $product->slug ?? $product->id) }}" 
                       class="product-card block border border-gray-200 rounded-2xl overflow-hidden hover:shadow-xl transition">
                        <div class="relative aspect-[4/5] bg-gray-100">
                            <img src="{{ $product->images && count($product->images) > 0 ? asset($product->images[0]) : 'https://picsum.photos/id/301/800/1000' }}" 
                                 class="w-full h-full object-cover" alt="{{ $product->name }}">
                            <div class="absolute top-4 left-4 bg-white text-xs font-bold px-3.5 py-1 rounded-full shadow">NEW</div>
                        </div>
                        <div class="p-4">
                            <div class="font-semibold text-lg">Rs. {{ number_format($product->price) }}</div>
                            <p class="text-sm text-gray-600 line-clamp-2 mt-1">{{ $product->name }}</p>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>

        <div class="mt-10 flex justify-center">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection