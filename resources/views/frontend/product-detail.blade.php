@extends('layouts.app')

@section('title', $product->name ?? 'Product Detail')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

@if(empty($product))
    <div class="text-center py-20">
        <h2 class="text-xl sm:text-2xl font-bold text-red-600">Product Not Found</h2>
    </div>
@else

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

    {{-- Image Gallery --}}
    <div>
        <div id="mainImageWrap"
             class="relative aspect-[3/4] bg-gray-100 rounded-2xl overflow-hidden border border-gray-200 cursor-zoom-in">
            <img
                id="mainImage"
                src="{{ !empty($product->images[0]) ? asset($product->images[0]) : 'https://picsum.photos/800/1000' }}"
                class="w-full h-full object-cover"
                alt="{{ $product->name }}"
                onclick="openImageLightbox()"
            >

            @if(!empty($product->images) && count($product->images) > 1)
                <button type="button"
                        onclick="event.stopPropagation(); prevLightboxImage();"
                        class="absolute left-2 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-black/25 hover:bg-black/40 text-white/80 hover:text-white flex items-center justify-center backdrop-blur-[1px] transition"
                        aria-label="Previous image">
                    <i class="fa-solid fa-chevron-left text-sm"></i>
                </button>
                <button type="button"
                        onclick="event.stopPropagation(); nextLightboxImage();"
                        class="absolute right-2 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-black/25 hover:bg-black/40 text-white/80 hover:text-white flex items-center justify-center backdrop-blur-[1px] transition"
                        aria-label="Next image">
                    <i class="fa-solid fa-chevron-right text-sm"></i>
                </button>
            @endif

            @if(!empty($product->discount_price) && $product->discount_price < $product->price)
                <div class="absolute top-3 left-3 bg-red-600 text-white text-xs font-semibold px-3 py-1 rounded z-10">
                    Sale
                </div>
            @else
                <div class="absolute top-3 left-3 bg-white text-black text-xs font-semibold px-3 py-1 rounded border z-10">
                    New
                </div>
            @endif
        </div>

        @if(!empty($product->images))
            <div class="grid grid-cols-4 sm:grid-cols-5 gap-3 mt-4">
                @foreach($product->images as $img)
                    <button type="button" onclick="changeMainImage('{{ asset($img) }}', this)"
                        class="thumb-btn aspect-[3/4] border border-gray-200 rounded-lg overflow-hidden bg-gray-100">
                        <img src="{{ asset($img) }}" class="w-full h-full object-cover">
                    </button>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Product Details --}}
    <div class="lg:pt-2">

        <div class="flex justify-between items-start">
            <h1 class="text-[22px] sm:text-[26px] lg:text-[30px] font-bold text-gray-900 flex-1">
                {{ $product->name }}
            </h1>

            @auth
                <button onclick="toggleWishlist({{ $product->id }})"
                    class="text-3xl pt-1 transition hover:scale-110">
                    <i id="heart-icon"
                       class="fa-heart cursor-pointer transition {{ $isInWishlist ?? false ? 'fa-solid text-red-500' : 'fa-regular text-gray-400 hover:text-gray-900' }}">
                    </i>
                </button>
            @endauth
        </div>

        {{-- Price --}}
        <div class="mt-4 flex items-center gap-3 flex-wrap">
            @if(!empty($product->discount_price) && $product->discount_price < $product->price)
                <span class="text-[22px] sm:text-[26px] font-bold text-red-600">
                    Rs. {{ number_format($product->discount_price) }}
                </span>
                <span class="text-sm sm:text-base text-gray-400 line-through">
                    Rs. {{ number_format($product->price ?? 0) }}
                </span>
            @else
                <span class="text-[22px] sm:text-[26px] font-bold text-black">
                    Rs. {{ number_format($product->price ?? 0) }}
                </span>
            @endif
        </div>

        @if(session('success'))
            <div class="mt-5 p-3 bg-green-100 text-green-700 text-sm rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mt-5 p-3 bg-red-100 text-red-700 text-sm rounded-lg">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Add to Cart / Buy Now --}}
        <form id="productForm" method="POST">
            @csrf

            <div class="mt-6 border-t border-gray-200 pt-5">
                <p class="text-sm font-semibold uppercase tracking-wide mb-3">
                    Quantity
                </p>

                <div class="inline-flex items-center border border-gray-300 rounded-lg overflow-hidden">
                    <button type="button" onclick="changeQty(-1)"
                        class="w-10 h-10 flex items-center justify-center text-lg hover:bg-gray-100">
                        -
                    </button>

                    <input id="qty" name="quantity" type="number" value="1" min="1"
                        class="w-14 h-10 text-center border-x border-gray-300 outline-none text-sm">

                    <button type="button" onclick="changeQty(1)"
                        class="w-10 h-10 flex items-center justify-center text-lg hover:bg-gray-100">
                        +
                    </button>
                </div>
            </div>

            <div class="mt-7 grid grid-cols-1 sm:grid-cols-2 gap-3">
                <button type="button"
                    onclick="submitProductForm('{{ route('cart.add', $product->id) }}')"
                    class="w-full bg-black text-white h-[48px] rounded-lg text-sm font-semibold uppercase hover:bg-gray-800 transition"
                    @if(($product->stock ?? 0) <= 0) disabled @endif>
                    Add To Cart
                </button>

                <button type="button"
                    onclick="submitProductForm('{{ route('cart.buyNow', $product->id) }}')"
                    class="w-full border border-black text-black h-[48px] rounded-lg text-sm font-semibold uppercase hover:bg-gray-50 transition"
                    @if(($product->stock ?? 0) <= 0) disabled @endif>
                    Buy Now
                </button>
            </div>
        </form>

    </div>

    {{-- Description + Product Details (below images) --}}
    <div class="lg:col-span-2">

        @if(!empty($product->description))
            <div class="mt-2 border-t border-gray-200 pt-5">
                <h3 class="text-sm font-semibold uppercase tracking-wide mb-2">
                    Description
                </h3>
                <p class="text-sm sm:text-[15px] text-gray-600 leading-7">
                    {{ $product->description }}
                </p>
            </div>
        @endif

        <div class="mt-6 border-t border-gray-200 pt-5">
            <h3 class="text-sm font-semibold uppercase tracking-wide mb-4">
                Product Details
            </h3>

            @php
                $categoryName = strtolower($product->category_name ?? $product->category ?? '');
                $isFragrance = str_contains($categoryName, 'fragrance');
            @endphp

            @if($isFragrance)

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm text-gray-700">

                    <div>
                        <span class="font-semibold text-black">Brand:</span>
                        {{ $product->brand_name ?? $product->brand ?? 'N/A' }}
                    </div>

                    <div>
                        <span class="font-semibold text-black">Gender:</span>
                        {{ $product->gender ?? 'N/A' }}
                    </div>

                    <div>
                        <span class="font-semibold text-black">Category:</span>
                        {{ $product->category_name ?? $product->category ?? 'Fragrances' }}
                    </div>

                    <div>
                        <span class="font-semibold text-black">Stock:</span>
                        @if(($product->stock ?? 0) > 0)
                            <span class="text-green-600 font-semibold">
                                {{ $product->stock }} Left
                            </span>
                        @else
                            <span class="text-red-600 font-semibold">
                                Out of Stock
                            </span>
                        @endif
                    </div>

                </div>

            @else

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm text-gray-700">

                    <div>
                        <span class="font-semibold text-black">Brand:</span>
                        {{ $product->brand_name ?? $product->brand ?? 'N/A' }}
                    </div>

                    <div>
                        <span class="font-semibold text-black">Category:</span>
                        {{ $product->category_name ?? $product->category ?? 'N/A' }}
                    </div>

                    <div>
                        <span class="font-semibold text-black">Gender:</span>
                        {{ $product->gender ?? 'N/A' }}
                    </div>

                    <div>
                        <span class="font-semibold text-black">Outfit Type:</span>
                        {{ $product->outfit_type_name ?? 'N/A' }}
                    </div>

                    <div>
                        <span class="font-semibold text-black">Color:</span>
                        {{ ($product->color_type ?? '') === 'Custom' ? ($product->color_type_custom ?? 'N/A') : ($product->color_type ?? 'N/A') }}
                    </div>

                    <div>
                        <span class="font-semibold text-black">Stock:</span>
                        @if(($product->stock ?? 0) > 0)
                            <span class="text-green-600 font-semibold">
                                {{ $product->stock }} Left
                            </span>
                        @else
                            <span class="text-red-600 font-semibold">
                                Out of Stock
                            </span>
                        @endif
                    </div>

                </div>

            @endif
        </div>

    </div>
</div>

{{-- Related Products --}}
<div class="mt-12 sm:mt-16">
    <h2 class="text-[20px] sm:text-2xl font-bold mb-5">
        Related Products
    </h2>

    @if(empty($relatedProducts) || $relatedProducts->isEmpty())
        <p class="text-gray-500 py-8">No related products found.</p>
    @else
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-5 lg:gap-6">
            @foreach($relatedProducts as $related)
              <a href="{{ route('product.detail', $related->slug ?? $related->id) }}"
                   class="group block border border-gray-200 rounded-xl overflow-hidden bg-white">
                    <div class="relative aspect-[3/4] overflow-hidden bg-gray-100">
                        <img
                            src="{{ !empty($related->images[0]) ? asset($related->images[0]) : 'https://picsum.photos/400/500' }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                            alt="{{ $related->name }}"
                        >

                        @if(!empty($related->discount_price) && $related->discount_price < $related->price)
                            <span class="absolute top-2 left-2 bg-red-600 text-white text-[10px] px-2 py-1 rounded">
                                Sale
                            </span>
                        @endif
                    </div>

                    <div class="p-3">
                        <p class="text-[12px] sm:text-sm font-medium line-clamp-2 min-h-[38px]">
                            {{ $related->name }}
                        </p>

                        <div class="mt-2 flex flex-wrap items-center gap-2">
                            <p class="text-sm sm:text-base text-red-600 font-semibold">
                                Rs. {{ number_format($related->discount_price ?? $related->price ?? 0) }}
                            </p>

                            @if(!empty($related->discount_price) && $related->discount_price < $related->price)
                                <p class="text-gray-400 line-through text-xs">
                                    Rs. {{ number_format($related->price ?? 0) }}
                                </p>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>

{{-- Portrait Image Lightbox --}}
<div id="imageLightbox"
     class="fixed inset-0 z-[99999] hidden items-center justify-center bg-black/90 p-4"
     onclick="closeImageLightbox()">
    <button type="button"
            onclick="closeImageLightbox()"
            class="absolute top-4 right-4 text-white text-4xl leading-none hover:text-gray-300 z-10"
            aria-label="Close">
        &times;
    </button>
    <img id="lightboxImage"
         src=""
         alt="{{ $product->name }}"
         class="max-h-[90vh] w-auto max-w-[min(90vw,420px)] object-contain rounded-lg shadow-2xl touch-pan-y select-none"
         onclick="event.stopPropagation()"
         draggable="false">
</div>

@endif

</div>

@if(!empty($product))
<script>
const productImages = @json(
    !empty($product->images)
        ? collect($product->images)->map(fn ($img) => asset($img))->values()
        : []
);
let lightboxIndex = 0;
let touchStartX = 0;
let touchEndX = 0;

function openImageLightbox() {
    const main = document.getElementById('mainImage');
    const lightbox = document.getElementById('imageLightbox');
    const lightboxImg = document.getElementById('lightboxImage');
    if (!main || !lightbox || !lightboxImg) return;

    const currentSrc = main.src;
    lightboxIndex = productImages.findIndex(src => currentSrc === src || currentSrc.endsWith(src.split('/').pop()));
    if (lightboxIndex < 0) lightboxIndex = 0;

    lightboxImg.src = productImages[lightboxIndex] || main.src;
    lightbox.classList.remove('hidden');
    lightbox.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeImageLightbox() {
    const lightbox = document.getElementById('imageLightbox');
    if (!lightbox) return;

    lightbox.classList.add('hidden');
    lightbox.classList.remove('flex');
    document.body.style.overflow = '';
}

function showLightboxImage(index) {
    if (!productImages.length) return;

    lightboxIndex = (index + productImages.length) % productImages.length;
    const src = productImages[lightboxIndex];
    const lightboxImg = document.getElementById('lightboxImage');
    const main = document.getElementById('mainImage');

    if (lightboxImg) lightboxImg.src = src;
    if (main) main.src = src;

    document.querySelectorAll('.thumb-btn').forEach((btn, i) => {
        btn.classList.remove('border-black');
        btn.classList.add('border-gray-200');
        if (i === lightboxIndex) {
            btn.classList.remove('border-gray-200');
            btn.classList.add('border-black');
        }
    });
}

function nextLightboxImage() {
    showLightboxImage(lightboxIndex + 1);
}

function prevLightboxImage() {
    showLightboxImage(lightboxIndex - 1);
}

(function setupLightboxSwipe() {
    const lightboxImg = document.getElementById('lightboxImage');
    if (!lightboxImg) return;

    lightboxImg.addEventListener('touchstart', function (e) {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    lightboxImg.addEventListener('touchend', function (e) {
        touchEndX = e.changedTouches[0].screenX;
        const diff = touchStartX - touchEndX;
        if (Math.abs(diff) < 40) return;
        if (diff > 0) nextLightboxImage();
        else prevLightboxImage();
    }, { passive: true });
})();

(function setupMainImageSwipe() {
    const wrap = document.getElementById('mainImageWrap');
    if (!wrap || productImages.length < 2) return;

    let startX = 0;
    let moved = false;

    wrap.addEventListener('touchstart', function (e) {
        startX = e.changedTouches[0].screenX;
        moved = false;
    }, { passive: true });

    wrap.addEventListener('touchmove', function (e) {
        if (Math.abs(e.changedTouches[0].screenX - startX) > 20) moved = true;
    }, { passive: true });

    wrap.addEventListener('touchend', function (e) {
        const endX = e.changedTouches[0].screenX;
        const diff = startX - endX;
        if (Math.abs(diff) < 40) return;
        if (diff > 0) nextLightboxImage();
        else prevLightboxImage();
    }, { passive: true });

    // Prevent lightbox open after swipe
    const main = document.getElementById('mainImage');
    if (main) {
        main.addEventListener('click', function (e) {
            if (moved) {
                e.stopImmediatePropagation();
                e.preventDefault();
                moved = false;
            }
        }, true);
    }
})();

document.addEventListener('keydown', function (e) {
    const lightbox = document.getElementById('imageLightbox');
    const isOpen = lightbox && !lightbox.classList.contains('hidden');

    if (e.key === 'Escape') closeImageLightbox();
    if (!isOpen) return;
    if (e.key === 'ArrowRight') nextLightboxImage();
    if (e.key === 'ArrowLeft') prevLightboxImage();
});

function changeMainImage(src, el) {
    document.getElementById('mainImage').src = src;

    document.querySelectorAll('.thumb-btn').forEach(btn => {
        btn.classList.remove('border-black');
        btn.classList.add('border-gray-200');
    });

    el.classList.remove('border-gray-200');
    el.classList.add('border-black');

    lightboxIndex = productImages.indexOf(src);
    if (lightboxIndex < 0) lightboxIndex = 0;
}

function changeQty(n) {
    let qty = document.getElementById('qty');
    let currentValue = parseInt(qty.value) || 1;
    let newValue = currentValue + n;

    if (newValue > 0) {
        qty.value = newValue;
    }
}

function submitProductForm(actionUrl) {
    const form = document.getElementById('productForm');
    form.action = actionUrl;
    form.submit();
}

function toggleWishlist(productId) {
    const heart = document.getElementById('heart-icon');
    if (!heart) return;

    fetch("{{ route('wishlist.toggle') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (heart.classList.contains('fa-solid')) {
                heart.classList.remove('fa-solid', 'text-red-500');
                heart.classList.add('fa-regular', 'text-gray-400');
            } else {
                heart.classList.remove('fa-regular', 'text-gray-400');
                heart.classList.add('fa-solid', 'text-red-500');
            }
        }
    })
    .catch(error => console.error('Wishlist Error:', error));
}
</script>
@endif

@endsection
