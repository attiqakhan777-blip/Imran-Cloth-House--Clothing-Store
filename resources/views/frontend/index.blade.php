
text/x-generic index.blade.php ( HTML document, UTF-8 Unicode text, with CRLF line terminators )
@extends('layouts.app')

@section('title', 'Imran Cloth House')

@section('content')

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .hero-slide {
        opacity: 0;
        pointer-events: none;
    }

    .hero-slide.active {
        opacity: 1;
        pointer-events: auto;
    }

    .glass-arrow {
        width: 42px;
        height: 42px;
        border-radius: 9999px;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.45);
        color: white;
        font-size: 26px;
        font-weight: 700;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.25);
        transition: all 0.25s ease;
        line-height: 1;
    }

    .glass-arrow:hover {
        background: rgba(255, 255, 255, 0.35);
    }

    .glass-arrow-dark {
        width: 38px;
        height: 38px;
        border-radius: 9999px;
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.85);
        color: #111827;
        font-size: 24px;
        font-weight: 700;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.18);
        transition: all 0.25s ease;
        line-height: 1;
    }

    .glass-arrow-dark:hover {
        background: rgba(255, 255, 255, 0.95);
    }

    @media (min-width: 768px) {
        .glass-arrow {
            width: 52px;
            height: 52px;
            font-size: 30px;
        }

        .glass-arrow-dark {
            width: 46px;
            height: 46px;
            font-size: 28px;
        }
    }
</style>

{{-- ================= HERO BANNER ================= --}}
<div class="w-full mt-4 sm:mt-6 px-2 sm:px-4 lg:px-6">

    <div class="relative h-[52vh] min-h-[360px] sm:h-[60vh] md:h-[68vh] lg:h-[78vh] rounded-[28px] sm:rounded-[34px] overflow-hidden shadow-xl sm:shadow-2xl bg-gray-100">

        <div id="hero-slider" class="relative h-full w-full rounded-[28px] sm:rounded-[34px] overflow-hidden">

            @if(!empty($hero) && count($hero) > 0)

                @foreach($hero as $index => $slide)

                    <a href="{{ $slide['link'] ?? '#' }}"
                       class="hero-slide absolute inset-0 transition-opacity duration-1000 ease-in-out {{ $index === 0 ? 'active' : '' }}">

                        @php
                            $heroImage = $slide['image'] ?? '';

                            if ($heroImage && !str_contains($heroImage, '/')) {
                                $heroImage = 'storage/uploads/home/hero/' . $heroImage;
                            }
                        @endphp

                        <picture>
                            <img
                                src="{{ asset($heroImage) }}"
                                class="w-full h-full object-cover object-center"
                                alt="{{ $slide['title'] ?? 'Imran Cloth House' }}"
                                fetchpriority="high"
                                decoding="async"
                            >
                        </picture>

                        <div class="absolute inset-0 bg-gradient-to-t from-black/45 via-black/10 to-transparent"></div>

                        <div class="absolute bottom-0 left-0 right-0 z-10 text-center text-white px-4 pb-5 sm:pb-7 md:pb-10">

                            @if(!empty($slide['title']))
                                <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-bold leading-tight drop-shadow-lg">
                                    {{ $slide['title'] }}
                                </h1>
                            @endif

                            @if(!empty($slide['subtitle']))
                                <p class="mt-2 text-sm sm:text-lg md:text-2xl drop-shadow">
                                    {{ $slide['subtitle'] }}
                                </p>
                            @endif

                        </div>

                    </a>

                @endforeach

            @else

                <div class="absolute inset-0 bg-black flex items-center justify-center text-center text-white px-6">
                    <h1 class="text-3xl sm:text-5xl md:text-7xl font-bold">
                        Imran Cloth House
                    </h1>
                </div>

            @endif

        </div>

        @if(!empty($hero) && count($hero) > 1)

            <button type="button"
                    onclick="prevSlide()"
                    class="glass-arrow absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 z-20 flex items-center justify-center">
                ‹
            </button>

            <button type="button"
                    onclick="nextSlide()"
                    class="glass-arrow absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 z-20 flex items-center justify-center">
                ›
            </button>

        @endif

    </div>

</div>

{{-- ================= COLLECTIONS ================= --}}
{{-- ================= COLLECTIONS ================= --}}
@if(!empty($collections) && count($collections) > 0)

<div class="w-full px-[15px] py-5 sm:py-7 overflow-hidden">

    <div class="relative group">

        {{-- Left Arrow --}}
        <button
            onclick="scrollCollection(-250)"
            class="hidden md:flex absolute left-2 top-1/2 -translate-y-1/2 z-20 glass-arrow-dark items-center justify-center opacity-0 group-hover:opacity-100 transition"
        >
            ‹
        </button>

        {{-- Right Arrow --}}
        <button
            onclick="scrollCollection(250)"
            class="hidden md:flex absolute right-2 top-1/2 -translate-y-1/2 z-20 glass-arrow-dark items-center justify-center opacity-0 group-hover:opacity-100 transition"
        >
            ›
        </button>

        {{-- Slider --}}
        <div
            id="category-slider"
            class="flex gap-2.5 sm:gap-3 md:gap-4 overflow-x-auto pb-3 scroll-smooth scrollbar-hide"
        >

            @foreach($collections as $cat)

                @php
                    $catTitle = $cat['title'] ?? 'Collection';
                    $catSlug = \Illuminate\Support\Str::slug($catTitle);
                @endphp

                <a
                    href="{{ $cat['link'] ?? url('collection/' . $catSlug) }}"
                    class="group flex-shrink-0 w-[110px] sm:w-[140px] md:w-[165px] lg:w-[185px]"
                >

                    <div class="bg-[#f1f1f1] rounded-[14px] sm:rounded-[16px] overflow-hidden shadow-sm hover:shadow-md transition">

                        <div class="h-[90px] sm:h-[115px] md:h-[130px] lg:h-[140px] overflow-hidden rounded-[14px] sm:rounded-[16px]">

       @php
$collectionImage = $cat['image'] ?? '';

if ($collectionImage && !str_contains($collectionImage,'/')) {
    $collectionImage='storage/uploads/home/collections/'.$collectionImage;
}
@endphp

<img
src="{{ asset($collectionImage) }}"
class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
alt="{{ $catTitle }}"
loading="lazy"
decoding="async"
>


                        </div>

                        <div class="h-[28px] sm:h-[32px] flex items-center justify-center bg-[#eeeeee] px-1">

                            <h3 class="text-[10px] sm:text-[12px] md:text-[13px] font-extrabold uppercase text-black tracking-wide text-center leading-none truncate">
                                {{ $catTitle }}
                            </h3>

                        </div>

                    </div>

                </a>

            @endforeach

        </div>

    </div>

</div>

@endif

{{-- ================= DYNAMIC PRODUCT SECTIONS ================= --}}
@if(!empty($sections))

    @foreach($sections as $section)

        @if(!in_array($section->section_name, ['hero', 'collections', 'shop_by_category']) && $section->is_active)

            <section class="bg-white py-3 sm:py-5">

                <div class="w-full px-[15px] overflow-hidden">

                    {{-- Heading --}}
                    <div class="flex items-center justify-between mb-4">

                        <h2 class="text-[16px] sm:text-[18px] md:text-[22px] font-semibold text-[#263b58] uppercase tracking-[0.08em] font-serif">
                            {{ $section->title ?? ucfirst(str_replace('_', ' ', $section->section_name)) }}
                        </h2>

                    </div>

                    <div class="relative group">

                        {{-- Left Arrow --}}
                        <button
                            onclick="sideScroll('scroll-{{ $section->section_name }}', -300)"
                            class="hidden md:flex absolute left-2 top-1/2 -translate-y-1/2 z-20 glass-arrow-dark items-center justify-center opacity-0 group-hover:opacity-100 transition"
                        >
                            ‹
                        </button>

                        {{-- Right Arrow --}}
                        <button
                            onclick="sideScroll('scroll-{{ $section->section_name }}', 300)"
                            class="hidden md:flex absolute right-2 top-1/2 -translate-y-1/2 z-20 glass-arrow-dark items-center justify-center opacity-0 group-hover:opacity-100 transition"
                        >
                            ›
                        </button>

                        {{-- Slider --}}
                        <div
                            id="scroll-{{ $section->section_name }}"
                            class="flex gap-3 sm:gap-4 overflow-x-auto scroll-smooth scrollbar-hide pb-3"
                        >

                            @foreach($section->data ?? [] as $item)

                                @php
                                    $itemTitle = $item['title'] ?? '';
                                    $itemSlug = \Illuminate\Support\Str::slug($itemTitle);
                                @endphp

                                <a
                                    href="{{ url('collection/' . $itemSlug) }}"
                                    class="block flex-shrink-0 w-[36%] sm:w-[26%] md:w-[20%] lg:w-[13%]"
                                >

                                 <div class="relative h-[150px] sm:h-[190px] md:h-[235px] lg:h-[270px] rounded-[12px] overflow-hidden shadow-sm">

     @php
$sectionImage = $item['image'] ?? '';

if ($sectionImage && !str_contains($sectionImage,'/')) {
    $sectionImage='storage/uploads/home/sections/'.$sectionImage;
}
@endphp

<img
src="{{ asset($sectionImage) }}"
alt="{{ $itemTitle }}"
class="w-full h-full object-cover object-top transition-transform duration-700 hover:scale-105"
loading="lazy"
decoding="async"
>

                                    <div class="absolute left-0 right-0 bottom-0 text-center text-white px-2 pt-4 pb-2 bg-black/20 backdrop-blur-[1.5px]">

    <h3 class="text-[10px] sm:text-[11px] md:text-[13px] font-semibold leading-tight drop-shadow">
        {{ $itemTitle }}
    </h3>

    @if(!empty($item['subtitle']))
        <p class="text-[8px] sm:text-[9px] md:text-[10px] text-white/85 mt-0.5 leading-tight drop-shadow">
            {{ $item['subtitle'] }}
        </p>
    @endif

</div>

                                    </div>

                                </a>

                            @endforeach

                        </div>

                    </div>

                </div>

            </section>

        @endif

    @endforeach

@endif
{{-- ================= SHOP BY CATEGORY ================= --}}
{{-- ================= SHOP BY CATEGORY ================= --}}
@if(!empty($sections) && isset($sections['shop_by_category']) && $sections['shop_by_category']->is_active)

    @php
        $shopCategorySection = $sections['shop_by_category'];
        $shopCategories = $shopCategorySection->data ?? [];
    @endphp

    @if(!empty($shopCategories) && count($shopCategories) > 0)

        <section class="bg-white py-6 sm:py-8">

            <div class="w-full px-[15px] overflow-hidden">

                {{-- Section Heading --}}
                <div class="mb-5 sm:mb-6 text-center">

                    <h2 class="text-[18px] sm:text-[22px] md:text-[26px] lg:text-[30px] font-semibold text-[#263b58] uppercase tracking-[0.08em] sm:tracking-[0.12em] font-serif">
                        {{ $shopCategorySection->title ?? 'SHOP BY CATEGORY' }}
                    </h2>

                </div>

                {{-- Category Grid --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4 place-items-center">

                  
@foreach($shopCategories as $item)
    @php
        $itemTitle = $item['title'] ?? '';
        $itemSlug = \Illuminate\Support\Str::slug($itemTitle);
    $link = !empty($item['link'])
    ? url($item['link'])
    : route('collection.show', $itemSlug);

        $categoryImage = $item['image'] ?? '';
        if ($categoryImage && !str_contains($categoryImage, '/')) {
            $categoryImage = 'storage/uploads/home/sections/' . $categoryImage;
        }
    @endphp

    <a href="{{ $link }}" class="group flex flex-col items-center text-center w-full">
        {{-- Square Image --}}
        <div class="relative w-full aspect-square overflow-hidden rounded-[18px]">
            @if($categoryImage)
                <img 
                    src="{{ asset($categoryImage) }}" 
                    alt="{{ $itemTitle }}" 
                    class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                    loading="lazy"
                    decoding="async"
                >
            @endif
        </div>

                            {{-- Title --}}
                            <h3 class="mt-2 w-full text-center text-[11px] sm:text-[13px] md:text-[15px] lg:text-[16px] font-semibold tracking-wide text-black group-hover:text-blue-600 transition">
                                {{ $itemTitle }}
                            </h3>

                        </a>

                    @endforeach

                </div>

            </div>

        </section>

    @endif

@endif

<script>
function scrollCollection(distance) {

    const slider = document.getElementById('category-slider');

    if (!slider) return;

    slider.scrollBy({
        left: distance,
        behavior: 'smooth'
    });

}

// Auto slide collections
setInterval(() => {

    const slider = document.getElementById('category-slider');

    if (!slider) return;

    slider.scrollBy({
        left: 220,
        behavior: 'smooth'
    });

    // Restart from beginning
    if (slider.scrollLeft + slider.clientWidth >= slider.scrollWidth - 5) {

        slider.scrollTo({
            left: 0,
            behavior: 'smooth'
        });

    }

}, 3000);
document.addEventListener('DOMContentLoaded', function () {

    let slides = document.querySelectorAll('.hero-slide');
    let currentSlide = 0;

    function showSlide(n) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === n);
        });
    }

    window.nextSlide = function () {
        if (slides.length === 0) return;
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    };

    window.prevSlide = function () {
        if (slides.length === 0) return;
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
    };

    if (slides.length > 1) {
        setInterval(window.nextSlide, 5000);
    }

});

function scrollCategory(direction) {

    const slider = document.getElementById('category-slider');

    if (!slider) return;

    slider.scrollBy({
        left: direction * 220,
        behavior: 'smooth'
    });

}

function sideScroll(elementId, distance) {

    const container = document.getElementById(elementId);

    if (!container) return;

    container.scrollBy({
        left: distance,
        behavior: 'smooth'
    });

}
</script>

@endsection