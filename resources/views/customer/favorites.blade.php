@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
<div class="min-h-screen bg-white py-12">
    <div class="max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold uppercase tracking-wide">My Wishlist</h1>
            <a href="{{ route('home') }}" class="text-black hover:underline">← Continue Shopping</a>
        </div>

        @if($favorites->isEmpty())
            <div class="text-center py-20 bg-gray-50 rounded-2xl">
                <i class="fa-solid fa-heart text-8xl text-gray-200 mb-6"></i>
                <h3 class="text-2xl font-medium text-gray-700">Your wishlist is empty</h3>
                <p class="text-gray-500 mt-3">You haven't saved any products yet.</p>
                <a href="{{ route('home') }}" class="mt-8 inline-block bg-black text-white px-10 py-4 rounded-lg hover:bg-gray-800">
                    Browse Products
                </a>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6" id="favoritesGrid">
                @foreach($favorites as $fav)
                    @php 
                        $product = $fav->product; 
                        // Improved Image Logic
                        $mainImage = null;
                        if (!empty($product->images) && is_array($product->images)) {
                            $mainImage = $product->images[0] ?? null;
                        } elseif (!empty($product->image)) {
                            $mainImage = $product->image;
                        }
                    @endphp

                    @if($product)
                    <div class="group border border-gray-200 rounded-xl overflow-hidden hover:shadow-2xl transition-all duration-300" 
                         id="card-{{ $product->id }}">

                        <div class="relative">
                            @if($mainImage)
                                <img src="{{ asset('storage/' . $mainImage) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-64 object-cover group-hover:scale-105 transition-transform">
                            @else
                                <div class="w-full h-64 bg-gray-100 flex items-center justify-center text-6xl text-gray-300">
                                    🛍️
                                </div>
                            @endif

                            <button onclick="removeFromWishlist({{ $product->id }})" 
                                    class="absolute top-3 right-3 bg-white p-2.5 rounded-full shadow hover:bg-red-500 hover:text-white transition-all">
                                <i class="fa-solid fa-heart text-red-500 text-xl"></i>
                            </button>
                        </div>

                        <div class="p-4">
                            <h3 class="font-semibold text-base leading-tight mb-1">{{ $product->name }}</h3>
                            <p class="text-gray-500 text-sm">{{ $product->category ?? $product->brand ?? 'N/A' }}</p>
                            
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-xl font-bold">
                                    Rs. {{ number_format($product->discount_price ?? $product->price ?? 0) }}
                                </span>
                                <a href="{{ route('product.detail', $product->slug ?? $product->id) }}" 
                                   class="text-black hover:underline text-sm font-medium">
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

    card.style.opacity = '0.6';

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
            card.style.transition = 'all 0.4s ease';
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';

            setTimeout(() => card.remove(), 400);
        }
    } catch (e) {
        console.error(e);
        alert('Failed to remove');
        card.style.opacity = '1';
    }
}
</script>
@endsection