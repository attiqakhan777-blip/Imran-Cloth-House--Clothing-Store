
text/x-generic favorites.blade.php ( HTML document, UTF-8 Unicode text, with CRLF line terminators )
@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
<div class="min-h-screen bg-white py-8 sm:py-12">

    <div class="max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 sm:mb-10 gap-4">
            <h1 class="text-2xl sm:text-3xl font-bold uppercase tracking-wide">My Wishlist</h1>
            <a href="{{ route('home') }}" class="text-black hover:underline text-sm sm:text-base">
                ← Continue Shopping
            </a>
        </div>

        @if($favorites->isEmpty())
            <div class="text-center py-20 bg-gray-50 rounded-3xl">
                <i class="fa-solid fa-heart text-8xl text-gray-200 mb-6"></i>
                <h3 class="text-2xl font-medium text-gray-700">Your wishlist is empty</h3>
                <p class="text-gray-500 mt-3 mb-8">You haven't saved any products yet.</p>
                <a href="{{ route('home') }}" 
                   class="inline-block bg-black text-white px-10 py-4 rounded-2xl hover:bg-gray-800 transition">
                    Browse Products
                </a>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 sm:gap-6" id="favoritesGrid">
                @foreach($favorites as $fav)
                    @php 
                        $product = $fav->product; 
                    @endphp

                    @if($product)
                    <div class="group border border-gray-200 rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 bg-white" 
                         id="card-{{ $product->id }}">

                        <!-- Image -->
                        <div class="relative aspect-square bg-gray-100">
                            @php
                                $imagePath = null;
                                if (!empty($product->images) && is_array($product->images) && count($product->images) > 0) {
                                    $imagePath = $product->images[0];
                                } elseif (!empty($product->image)) {
                                    $imagePath = $product->image;
                                }
                            @endphp

                            @if($imagePath)
                               <img
    src="{{ asset($imagePath) }}"
    alt="{{ $product->name }}"
    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
>
                            @else
                                <div class="w-full h-full flex items-center justify-center text-6xl text-gray-300">
                                    🛍️
                                </div>
                            @endif

                            <!-- Remove Button -->
                            <button onclick="removeFromWishlist({{ $product->id }})" 
                                    class="absolute top-3 right-3 bg-white p-2.5 rounded-full shadow hover:bg-red-500 hover:text-white transition-all">
                                <i class="fa-solid fa-heart text-red-500 text-xl"></i>
                            </button>
                        </div>

                        <!-- Info -->
                        <div class="p-3 sm:p-4">
                            <h3 class="font-medium text-sm sm:text-base leading-tight line-clamp-2 mb-1">
                                {{ $product->name }}
                            </h3>
                            <p class="text-xs sm:text-sm text-gray-500">
                                {{ $product->category ?? $product->brand ?? 'N/A' }}
                            </p>
                            
                            <div class="mt-3 flex items-center justify-between">
                                <span class="font-bold text-base sm:text-lg">
                                    Rs. {{ number_format($product->discount_price ?? $product->price ?? 0) }}
                                </span>
                                <a href="{{ route('product.detail', $product->slug ?? $product->id) }}" 
                                   class="text-xs sm:text-sm text-black hover:underline">
                                    View →
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        @endif

    </div>
</div>

<script>
async function removeFromWishlist(productId) {
    const card = document.getElementById(`card-${productId}`);
    if (!card) return;

    card.style.transition = 'all 0.4s ease';
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';

    try {
        const response = await fetch("{{ route('wishlist.toggle') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ product_id: productId })
        });

        const data = await response.json();

        if (data.success) {
            setTimeout(() => {
                card.remove();
                if (document.querySelectorAll('#favoritesGrid > div').length === 0) {
                    location.reload();
                }
            }, 400);
        }
    } catch (e) {
        console.error(e);
        card.style.opacity = '1';
    }
}
</script>
@endsection