
text/x-generic brands.blade.php ( HTML document, UTF-8 Unicode text, with CRLF line terminators )
@extends('layouts.app')

@section('title', 'Brands')

@section('content')
<div class="w-full px-[15px] py-6 sm:py-10 lg:py-14 overflow-hidden">

    {{-- Breadcrumb --}}
    <div class="flex items-center text-xs sm:text-sm text-gray-500 mb-6">
        <a href="{{ route('home') }}" class="hover:text-black transition">Home</a>
        <span class="mx-2">›</span>
        <span class="text-black font-medium">Brands</span>
    </div>

    {{-- Page Header --}}
    <div class="text-center mb-8 sm:mb-12">
        <h1 class="text-2xl sm:text-4xl lg:text-5xl font-bold tracking-tight text-gray-900">
            Our Brands
        </h1>
        <p class="mt-2 sm:mt-3 text-gray-600 max-w-md mx-auto text-sm sm:text-lg">
            Discover premium fashion from trusted brands
        </p>
    </div>

    {{-- Tabs --}}
    <div class="flex justify-center gap-3 mb-8">
        <button type="button" onclick="showBrands('women')" id="womenBtn" class="brand-tab active-brand-tab">
            Women Brands
        </button>

        <button type="button" onclick="showBrands('men')" id="menBtn" class="brand-tab">
            Men Brands
        </button>
    </div>

    {{-- Alphabet Filter --}}
    <div class="sticky top-[95px] sm:top-4 z-40 bg-white border-b border-gray-100 py-3 sm:py-4 mb-8 sm:mb-10">
        <div class="flex overflow-x-auto scrollbar-hide gap-1 bg-gray-50 rounded-2xl p-2 w-full sm:w-fit sm:mx-auto">
            <a href="#all" class="alphabet-link active">ALL</a>

            @foreach(range('A', 'Z') as $letter)
                <a href="#letter-{{ $letter }}" class="alphabet-link">{{ $letter }}</a>
            @endforeach

            <a href="#letter-hash" class="alphabet-link">#</a>
        </div>
    </div>

    {{-- WOMEN SECTION --}}
    <div id="women-brands" class="brand-section">

        <div class="space-y-10 sm:space-y-14" id="all">
            @foreach(range('A', 'Z') as $letter)
                @php
                    $brandsByLetter = $womenBrands->filter(function($brand) use ($letter) {
                        return strtoupper(substr($brand, 0, 1)) === $letter;
                    });
                @endphp

                @if($brandsByLetter->count() > 0)
                    <div id="letter-{{ $letter }}" class="scroll-mt-28">
                        <div class="flex items-center gap-4 sm:gap-6 mb-5 sm:mb-6">
                            <h2 class="text-3xl sm:text-5xl font-bold text-gray-900 w-10 sm:w-20">
                                {{ $letter }}
                            </h2>
                            <div class="h-px flex-1 bg-gradient-to-r from-gray-200 to-transparent"></div>
                        </div>

                        <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-x-5 sm:gap-x-8 gap-y-4 sm:gap-y-5">
                           @foreach($brandsByLetter->reject(fn($brand) => in_array(strtolower(trim($brand)), ['maria.b','none'])) as $brand)
                                <a href="{{ route('frontend.collection', \Illuminate\Support\Str::slug($brand)) }}?gender=women"
                                   class="group text-sm sm:text-base font-medium text-gray-700 hover:text-black transition flex items-center gap-2 min-w-0">
                                    <span class="text-amber-500 group-hover:translate-x-1 transition flex-shrink-0">→</span>
                                    <span class="truncate">{{ $brand }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach

            @php
                $hashWomenBrands = $womenBrands->filter(function($brand) {
                    return !preg_match('/[A-Z]/', strtoupper(substr($brand, 0, 1)));
                });
            @endphp

            @if($hashWomenBrands->count() > 0)
                <div id="letter-hash" class="scroll-mt-28">
                    <div class="flex items-center gap-4 sm:gap-6 mb-5 sm:mb-6">
                        <h2 class="text-3xl sm:text-5xl font-bold text-gray-900 w-10 sm:w-20">#</h2>
                        <div class="h-px flex-1 bg-gradient-to-r from-gray-200 to-transparent"></div>
                    </div>

                    <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-x-5 sm:gap-x-8 gap-y-4 sm:gap-y-5">
                        @foreach($hashWomenBrands as $brand)
                            <a href="{{ route('frontend.collection', \Illuminate\Support\Str::slug($brand)) }}?gender=women"
                               class="group text-sm sm:text-base font-medium text-gray-700 hover:text-black transition flex items-center gap-2 min-w-0">
                                <span class="text-amber-500 group-hover:translate-x-1 transition flex-shrink-0">→</span>
                                <span class="truncate">{{ $brand }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        @if($womenBrands->count() == 0)
            <div class="text-center py-16 sm:py-20 text-gray-500 text-base sm:text-lg">
                No women brands available.
            </div>
        @endif

    </div>

    {{-- MEN SECTION --}}
    <div id="men-brands" class="brand-section hidden">

        <div class="space-y-10 sm:space-y-14">
            @foreach(range('A', 'Z') as $letter)
                @php
                    $brandsByLetter = $menBrands->filter(function($brand) use ($letter) {
                        return strtoupper(substr($brand, 0, 1)) === $letter;
                    });
                @endphp

                @if($brandsByLetter->count() > 0)
                    <div id="men-letter-{{ $letter }}" class="scroll-mt-28">
                        <div class="flex items-center gap-4 sm:gap-6 mb-5 sm:mb-6">
                            <h2 class="text-3xl sm:text-5xl font-bold text-gray-900 w-10 sm:w-20">
                                {{ $letter }}
                            </h2>
                            <div class="h-px flex-1 bg-gradient-to-r from-gray-200 to-transparent"></div>
                        </div>

                        <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-x-5 sm:gap-x-8 gap-y-4 sm:gap-y-5">
                            @foreach($brandsByLetter as $brand)
                                <a href="{{ route('frontend.collection', \Illuminate\Support\Str::slug($brand)) }}?gender=men"
                                   class="group text-sm sm:text-base font-medium text-gray-700 hover:text-black transition flex items-center gap-2 min-w-0">
                                    <span class="text-amber-500 group-hover:translate-x-1 transition flex-shrink-0">→</span>
                                    <span class="truncate">{{ $brand }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach

            @php
                $hashMenBrands = $menBrands->filter(function($brand) {
                    return !preg_match('/[A-Z]/', strtoupper(substr($brand, 0, 1)));
                });
            @endphp

            @if($hashMenBrands->count() > 0)
                <div id="men-letter-hash" class="scroll-mt-28">
                    <div class="flex items-center gap-4 sm:gap-6 mb-5 sm:mb-6">
                        <h2 class="text-3xl sm:text-5xl font-bold text-gray-900 w-10 sm:w-20">#</h2>
                        <div class="h-px flex-1 bg-gradient-to-r from-gray-200 to-transparent"></div>
                    </div>

                    <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-x-5 sm:gap-x-8 gap-y-4 sm:gap-y-5">
                        @foreach($hashMenBrands as $brand)
                            <a href="{{ route('frontend.collection', \Illuminate\Support\Str::slug($brand)) }}?gender=men"
                               class="group text-sm sm:text-base font-medium text-gray-700 hover:text-black transition flex items-center gap-2 min-w-0">
                                <span class="text-amber-500 group-hover:translate-x-1 transition flex-shrink-0">→</span>
                                <span class="truncate">{{ $brand }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        @if($menBrands->count() == 0)
            <div class="text-center py-16 sm:py-20 text-gray-500 text-base sm:text-lg">
                No men brands available.
            </div>
        @endif

    </div>

</div>

<style>
    .brand-tab {
        padding: 12px 24px;
        border-radius: 9999px;
        font-weight: 600;
        background: #f3f4f6;
        color: #374151;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .active-brand-tab {
        background: #111827;
        color: white;
    }

    .alphabet-link {
        padding: 8px 13px;
        border-radius: 9999px;
        font-weight: 600;
        color: #4b5563;
        transition: all 0.3s ease;
        white-space: nowrap;
        font-size: 13px;
        min-width: 40px;
        text-align: center;
        flex-shrink: 0;
    }

    @media (min-width: 640px) {
        .alphabet-link {
            padding: 10px 16px;
            font-size: 14px;
            min-width: 44px;
        }
    }

    .alphabet-link:hover,
    .alphabet-link.active {
        background: #111827;
        color: white;
        transform: scale(1.05);
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<script>
function showBrands(type) {
    const women = document.getElementById('women-brands');
    const men = document.getElementById('men-brands');

    const womenBtn = document.getElementById('womenBtn');
    const menBtn = document.getElementById('menBtn');

    if (type === 'women') {
        women.classList.remove('hidden');
        men.classList.add('hidden');

        womenBtn.classList.add('active-brand-tab');
        menBtn.classList.remove('active-brand-tab');
    } else {
        men.classList.remove('hidden');
        women.classList.add('hidden');

        menBtn.classList.add('active-brand-tab');
        womenBtn.classList.remove('active-brand-tab');
    }
}
</script>

@endsection