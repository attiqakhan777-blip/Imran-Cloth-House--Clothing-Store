<!DOCTYPE html>
<html lang="en">
     <head>
          <meta charset="UTF-8"> 
          <meta name="csrf-token" content="{{ csrf_token() }}">
          <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
          <title>@yield('title') | Imran Cloth House</title> 
          <meta name="description" content="@yield('meta_description', 'Imran Cloth House offers quality unstitched clothes, fabrics, and clothing variety since 1990.')"> 
          <meta name="keywords" content="@yield('meta_keywords', 'Imran Cloth House, unstitched clothes, clothing brand Pakistan, fabrics, women clothes, men clothes, fragrances')"> 
          <link rel="icon" type="image/png" href="{{ asset('images/lgo.png') }}">
          <link rel="apple-touch-icon" href="{{ asset('images/lgo.png') }}">
          <meta property="og:image" content="https://www.imranclothhouse.com/images/lgo.png">
          <meta property="og:site_name" content="Imran Cloth House"> <meta property="og:type" content="website"> <script type="application/ld+json"> { "@@context": "https://schema.org", "@type": "Organization", "name": "Imran Cloth House", "url": "https://www.imranclothhouse.com", "logo": "https://www.imranclothhouse.com/images/lgo.png" } </script> <link rel="preconnect" href="https://fonts.googleapis.com"> <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> <link href="https://fonts.googleapis.com/css2?family=Exo:wght@400;500;600;700&display=swap" rel="stylesheet"> <script src="https://cdn.tailwindcss.com"></script> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> <style> body { font-family: 'Exo', system-ui, sans-serif; } .logo-font { font-family: 'Exo', sans-serif; font-weight: 700; } @keyframes floatWhatsapp { 0%,100%{ transform: translateY(0); } 50%{ transform: translateY(-6px); } } .whatsapp-chat-btn{ animation: floatWhatsapp 3s ease-in-out infinite; } @keyframes whatsappFloat { 0%, 100% { transform: translateY(0) scale(1); } 50% { transform: translateY(-7px) scale(1.04); } } @keyframes whatsappRing { 0% { transform: scale(1); opacity: .45; } 100% { transform: scale(1.8); opacity: 0; } } @keyframes whatsappPopupIn { 0% { opacity: 0; transform: translateY(25px) scale(.92); } 100% { opacity: 1; transform: translateY(0) scale(1); } } @keyframes whatsappMessageIn { 0% { opacity: 0; transform: translateX(-15px); } 100% { opacity: 1; transform: translateX(0); } }
/* FREE SHIPPING MARQUEE BAR */
/* ================= TOP INFO BAR ================= */

.top-info-bar{
    width:100%;
    background:#000;
    color:#fff;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:42px;
    padding:0 15px;
    position:sticky;
    top:0;
    left:0;
    z-index:9999;
    border-bottom:1px solid rgba(255,255,255,0.12);
}

.top-info-bar p{
    margin:0;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:14px;
    font-size:13px;
    font-weight:500;   /* Semi Bold */
    letter-spacing:.4px;
    text-align:center;
}

.top-info-bar .separator{
    color:#777;
}

@media (max-width:768px){

    .top-info-bar{
        min-height:40px;
        padding:8px 12px;
    }

    .top-info-bar p{
        font-size:11px;
        gap:8px;
        flex-wrap:wrap;
        line-height:1.4;
    }

    .top-info-bar .separator{
        display:none;
    }

}
 </style> </head> <body class="bg-white"> <!-- ================= TOP INFO BAR ================= -->

<div class="top-info-bar">
    <p>
        FREE SHIPPING ON ORDERS PKR 20,000 OR ABOVE
        <span class="separator">|</span>
        100% ORIGINAL BRANDS
    </p>
</div>
      </div> 
      <header class="bg-white border-b sticky top-[40px] z-50 shadow-sm"> 
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> 
            <div class="hidden md:flex items-center justify-between py-4 sm:py-5 gap-4">
                 <a href="{{ route('home') }}" class="flex items-center gap-3 flex-shrink-0"> 
                    <img src="{{ asset('images/logo.png') }}" alt="ICH" class="h-10 w-10 sm:h-11 sm:w-11 rounded-full object-cover">
                     <span class="logo-font text-xl sm:text-2xl font-semibold tracking-tight hidden sm:inline"> Imran Cloth House </span> 
                    </a> <div class="flex-1 max-w-2xl mx-10 hidden md:block">
                         <form action="{{ route('frontend.search') }}" method="GET" class="relative">
                             <input type="text" name="q" value="{{ request('q') }}" placeholder="Search entire store here..." 
                             class="w-full bg-gray-100 border border-gray-200 rounded-full py-3 px-6 pl-12 focus:outline-none 
                             focus:border-gray-400 text-sm"> <button type="submit" class="absolute left-5 top-3.5 text-gray-400"> 
                                <i class="fa-solid fa-magnifying-glass"></i> 
                            </button> 
                        </form>
                     </div> 
                     <div class="flex items-center gap-4 sm:gap-6 text-xl sm:text-2xl text-gray-600">
                         @auth 
                         <button type="button" onclick="openCustomerDrawer()" class="hover:text-gray-900 transition">
                             <i class="fa-solid fa-user cursor-pointer"></i>
                             </button> 
                             @else 
                             <button type="button" onclick="openLoginDrawer()" class="hover:text-gray-900 transition">
                                 <i class="fa-solid fa-user cursor-pointer"></i>
                                 </button> 
                                 @endauth
                               {{-- Wishlist --}}
@php
    if(auth()->check()){
        $wishlistCount = \App\Models\Favorite::where('user_id', auth()->id())->count();
    } else {
        $wishlistCount = count(session('wishlist', []));
    }
@endphp

<a href="{{ route('customer.favorites') }}"
   class="relative hover:text-gray-900 transition">
    <i class="fa-regular fa-heart cursor-pointer text-xl"></i>

    @if($wishlistCount > 0)
        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] min-w-[16px] h-4 rounded-full flex items-center justify-center">
            {{ $wishlistCount }}
        </span>
    @endif
</a>
                                         @php $cartCount = collect(session('cart', []))->sum('quantity');
                                         @endphp <a href="{{ route('cart.index') }}" class="relative hover:text-gray-900 transition">
                                          <i class="fa-solid fa-bag-shopping cursor-pointer"></i> 
                                          <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] w-5 h-5 rounded-full flex items-center justify-center"> {{ $cartCount }} </span>
                                         </a> 
                                        </div> 
                                    </div>
                                     <div class="md:hidden py-4">
                                             <div class="relative flex items-center justify-center mb-4"> 
                                                <button type="button" onclick="openMobileMenu()" class="absolute left-0 text-2xl text-gray-700"> <i class="fa-solid fa-bars"></i>
                                                 </button> <a href="{{ route('home') }}" class="flex flex-col items-center">
                                                     <img src="{{ asset('images/logo.png') }}" alt="ICH" class="h-12 w-12 rounded-full object-cover"> <span class="logo-font text-lg font-semibold tracking-tight mt-1">Imran Cloth House</span>
                                                     </a> <div class="absolute right-0 flex items-center gap-4 text-[20px] text-gray-600">

    {{-- User --}}
    @auth
        <button type="button"
                onclick="openCustomerDrawer()"
                class="hover:text-gray-900 transition">
            <i class="fa-solid fa-user"></i>
        </button>
    @else
        <button type="button"
                onclick="openLoginDrawer()"
                class="hover:text-gray-900 transition">
            <i class="fa-solid fa-user"></i>
        </button>
    @endauth

   {{-- Wishlist --}}
@php
    if(auth()->check()){
        $wishlistCount = \App\Models\Favorite::where('user_id', auth()->id())->count();
    }else{
        $wishlistCount = count(session('wishlist', []));
    }
@endphp

@if(auth()->check())
    <a href="{{ route('customer.favorites') }}"
       class="relative hover:text-red-500 transition">
        <i class="fa-regular fa-heart"></i>

        @if($wishlistCount > 0)
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] w-5 h-5 rounded-full flex items-center justify-center">
                {{ $wishlistCount }}
            </span>
        @endif
    </a>
@else
    <a href="{{ route('customer.favorites') }}"
       class="relative hover:text-red-500 transition">
        <i class="fa-regular fa-heart"></i>

        @if($wishlistCount > 0)
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] w-5 h-5 rounded-full flex items-center justify-center">
                {{ $wishlistCount }}
            </span>
        @endif
    </a>
@endif

    {{-- Cart --}}
    @php
        $cartCount = collect(session('cart', []))->sum('quantity');
    @endphp

    <a href="{{ route('cart.index') }}"
       class="relative hover:text-gray-900 transition">
        <i class="fa-solid fa-bag-shopping"></i>

        <span class="absolute -top-2 -right-2 bg-red-600 text-white text-[10px] w-5 h-5 rounded-full flex items-center justify-center">
            {{ $cartCount }}
        </span>
    </a>

</div>
                                                         </div>
                                                          <form action="{{ route('frontend.search') }}" method="GET" class="relative">
                                                             <input type="text" name="q" value="{{ request('q') }}" placeholder="Search entire store here..."
                                                              class="w-full bg-gray-100 border border-gray-200 rounded-full py-3 px-6 pl-12 pr-4 focus:outline-none
                                                               focus:border-gray-400 text-sm"> 
                                                            <button type="submit" class="absolute left-5 top-3.5 text-gray-400">
                                                                 <i class="fa-solid fa-magnifying-glass">
          
      </i>
     </button>
      </form> 
      </div>
     </div>
      <nav class="hidden md:block bg-black text-white py-3.5 w-full relative z-[80]"> 
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-center gap-10 text-sm font-medium"> {{-- NEW ARRIVALS --}} 
        <div class="relative group shrink-0">
           <a href="{{ route('frontend.collection', 'new-arrivals') }}" class="hover:text-amber-400"> NEW ARRIVALS </a>
            <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[220px] bg-[#f3f4f6] text-gray-600 shadow-md border border-gray-200 opacity-0 invisible group-hover:opacity-100 
            group-hover:visible translate-y-1 group-hover:translate-y-0 transition-all duration-300 ease-out z-[9999]"> 
            <a href="{{ route('frontend.collection', 'women') }}" class="block px-5 py-3 text-[13px] border-b border-gray-200 hover:text-black hover:bg-white transition"> Women </a>
           <a href="{{ route('frontend.collection', 'men') }}" class="block px-5 py-3 text-[13px] border-b border-gray-200 hover:text-black hover:bg-white transition"> Men </a>
           </div>
         </div>
          {{-- WOMEN --}} 
          <div class="relative group shrink-0"> 
            <a href="{{ route('frontend.collection', 'women') }}" class="hover:text-amber-400"> WOMEN </a>
           <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[220px] bg-[#f3f4f6] text-gray-600 shadow-md border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-1 group-hover:translate-y-0 transition-all duration-300 ease-out z-[9999]"> 
           @forelse(($womenCategories ?? collect())->reject(fn($item) => $item == 'M.Print Lawn')->take(8) as $category) 
           <a href="{{ route('frontend.collection', \Illuminate\Support\Str::slug($category)) }}" class="block px-5 py-3 text-[13px] border-b border-gray-200 hover:text-black hover:bg-white transition"> {{ $category }} 
           </a>
            @empty 
           <span class="block px-5 py-3 text-[13px] text-gray-400">No women categories</span> 
           @endforelse </div> 
        </div> {{-- SALE --}}
           <div class="relative group shrink-0">
                <a href="{{ route('frontend.collection', 'sale') }}" class="hover:text-amber-400"> SALE </a>
                <div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[260px] max-h-[70vh] overflow-y-auto bg-[#f3f4f6] text-gray-600 shadow-md border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-1 group-hover:translate-y-0 transition-all duration-300 ease-out z-[9999]">

                    {{-- Men + categories --}}
                    <div class="border-b border-gray-200">
                        <a href="{{ route('frontend.collection', 'sale') }}?gender=Men"
                           class="block px-5 py-3 text-[13px] font-semibold text-black hover:bg-white transition">
                            Men
                        </a>
                        <a href="{{ route('frontend.collection', 'sale') }}?gender=Men"
                           class="block px-5 py-2 pl-8 text-[12px] hover:text-black hover:bg-white transition">
                            All Men Sale
                        </a>
                        @forelse(($saleMenCategories ?? collect())->take(10) as $category)
                            @php $catSlug = \Illuminate\Support\Str::slug($category); @endphp
                            <a href="{{ route('frontend.collection', 'sale') }}?gender=Men&category={{ $catSlug }}"
                               class="block px-5 py-2 pl-8 text-[12px] border-t border-gray-100 hover:text-black hover:bg-white transition">
                                {{ $category }}
                            </a>
                        @empty
                            <span class="block px-5 py-2 pl-8 text-[12px] text-gray-400">No sale categories</span>
                        @endforelse
                    </div>

                    {{-- Women + categories --}}
                    <div>
                        <a href="{{ route('frontend.collection', 'sale') }}?gender=Women"
                           class="block px-5 py-3 text-[13px] font-semibold text-black hover:bg-white transition">
                            Women
                        </a>
                        <a href="{{ route('frontend.collection', 'sale') }}?gender=Women"
                           class="block px-5 py-2 pl-8 text-[12px] hover:text-black hover:bg-white transition">
                            All Women Sale
                        </a>
                        @forelse(($saleWomenCategories ?? collect())->take(10) as $category)
                            @php $catSlug = \Illuminate\Support\Str::slug($category); @endphp
                            <a href="{{ route('frontend.collection', 'sale') }}?gender=Women&category={{ $catSlug }}"
                               class="block px-5 py-2 pl-8 text-[12px] border-t border-gray-100 hover:text-black hover:bg-white transition">
                                {{ $category }}
                            </a>
                        @empty
                            <span class="block px-5 py-2 pl-8 text-[12px] text-gray-400">No sale categories</span>
                        @endforelse
                    </div>

                </div>
           </div> {{-- MEN --}} <div class="relative group shrink-0"> <a href="{{ route('frontend.collection', 'men') }}" class="hover:text-amber-400"> MEN </a> 
<div class="absolute left-1/2 -translate-x-1/2 top-full mt-2 w-[220px] bg-[#f3f4f6] text-gray-600 shadow-md border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-1 group-hover:translate-y-0 transition-all duration-300 ease-out z-[9999]"> 
@forelse(($menCategories ?? collect())->take(8) as $category) 
<a href="{{ route('frontend.collection', \Illuminate\Support\Str::slug($category)) }}" class="block px-5 py-3 text-[13px] border-b border-gray-200 hover:text-black hover:bg-white transition"> {{ $category }} </a>
@empty <span class="block px-5 py-3 text-[13px] text-gray-400">No men categories</span> @endforelse </div> 
</div> <a href="{{ route('frontend.fragrances') }}" class="hover:text-amber-400"> FRAGRANCES </a>
<a href="{{ route('frontend.brands') }}" class="hover:text-amber-400"> BRANDS </a> 
</div>
 </nav> 
</header>

<div id="mobileMenuOverlay" onclick="closeMobileMenu()" class="fixed inset-0 bg-black/60 z-[9998] hidden md:hidden"></div>
<div id="mobileMenuDrawer" class="fixed top-0 left-0 h-full w-[82%] max-w-[340px] bg-white z-[9999] -translate-x-full transition-transform duration-300 overflow-y-auto md:hidden"> 
<div class="p-5"> <div class="flex items-center justify-between mb-6"> <h2 class="text-xl font-bold">Menu</h2>
     <button onclick="closeMobileMenu()" class="text-3xl leading-none">&times;</button> 
</div> <div class="space-y-1 text-[15px] font-semibold uppercase"> 
    {{-- NEW ARRIVALS DROPDOWN --}} 
    <div class="border-b">
         <button type="button" onclick="toggleMobileDropdown('newArrivalMenu')" class="w-full flex justify-between items-center py-4"> 
<span>New Arrivals</span> <i class="fa-solid fa-chevron-down text-xs"></i> </button> <div id="newArrivalMenu" class="hidden pl-4 pb-3 space-y-2 text-[14px] font-medium text-gray-600"> <a href="{{ route('frontend.collection', 'women') }}" class="block py-2">Women</a>
<a href="{{ route('frontend.collection', 'men') }}" class="block py-2">Men</a> </div> </div> 
{{-- WOMEN DROPDOWN --}} 
<div class="border-b"> 
    <button type="button" onclick="toggleMobileDropdown('womenMenu')" class="w-full flex justify-between items-center py-4"> 
        <span>Women</span> <i class="fa-solid fa-chevron-down text-xs"></i> </button> 
        <div id="womenMenu" class="hidden pl-4 pb-3 space-y-2 text-[14px] font-medium text-gray-600"> 
            <a href="{{ route('frontend.collection', 'women') }}" class="block py-2">All Women</a> 
            @forelse(($womenCategories ?? collect())->reject(fn($item) => $item == 'M.Print Lawn')->take(8) as $category)
             <a href="{{ route('frontend.collection', \Illuminate\Support\Str::slug($category)) }}" class="block py-2"> {{ $category }} </a>
              @empty <span class="block py-2 text-gray-400">No women categories</span>
               @endforelse 
            </div> 
            </div> 
{{-- SALE DROPDOWN --}}
 <div class="border-b"> 
    <button type="button" onclick="toggleMobileDropdown('saleMenu')" class="w-full flex justify-between items-center py-4">
     <span>Sale</span>
     <i class="fa-solid fa-chevron-down text-xs"></i> 
     </button> <div id="saleMenu" class="hidden pl-4 pb-3 space-y-1 text-[14px] font-medium text-gray-600">
<a href="{{ route('frontend.collection', 'sale') }}" class="block py-2 font-semibold text-black">All Sale</a>

{{-- Men Sale first --}}
<button type="button" onclick="toggleMobileDropdown('saleMenMenu')" class="w-full flex justify-between items-center py-2 text-left">
    <span>Men</span>
    <i class="fa-solid fa-chevron-down text-[10px]"></i>
</button>
<div id="saleMenMenu" class="hidden pl-3 pb-2 space-y-1">
    <a href="{{ route('frontend.collection', 'sale') }}?gender=Men" class="block py-2">All Men Sale</a>
    @forelse(($saleMenCategories ?? collect())->take(8) as $category)
        @php $catSlug = \Illuminate\Support\Str::slug($category); @endphp
        <a href="{{ route('frontend.collection', 'sale') }}?gender=Men&category={{ $catSlug }}" class="block py-2">
            {{ $category }}
        </a>
    @empty
        <span class="block py-2 text-gray-400">No sale items</span>
    @endforelse
</div>

{{-- Women Sale --}}
<button type="button" onclick="toggleMobileDropdown('saleWomenMenu')" class="w-full flex justify-between items-center py-2 text-left">
    <span>Women</span>
    <i class="fa-solid fa-chevron-down text-[10px]"></i>
</button>
<div id="saleWomenMenu" class="hidden pl-3 pb-2 space-y-1">
    <a href="{{ route('frontend.collection', 'sale') }}?gender=Women" class="block py-2">All Women Sale</a>
    @forelse(($saleWomenCategories ?? collect())->take(8) as $category)
        @php $catSlug = \Illuminate\Support\Str::slug($category); @endphp
        <a href="{{ route('frontend.collection', 'sale') }}?gender=Women&category={{ $catSlug }}" class="block py-2">
            {{ $category }}
        </a>
    @empty
        <span class="block py-2 text-gray-400">No sale items</span>
    @endforelse
</div>
</div> </div> {{-- MEN DROPDOWN --}} <div class="border-b"> 
    <button type="button" onclick="toggleMobileDropdown('menMenu')" class="w-full flex justify-between items-center py-4"> 
        <span>Men</span> <i class="fa-solid fa-chevron-down text-xs"></i> 
    </button> 
        <div id="menMenu" class="hidden pl-4 pb-3 space-y-2 text-[14px] font-medium text-gray-600">
             <a href="{{ route('frontend.collection', 'men') }}" class="block py-2">All Men</a> 
             @forelse(($menCategories ?? collect())->take(8) as $category) 
             <a href="{{ route('frontend.collection', \Illuminate\Support\Str::slug($category)) }}" class="block py-2"> {{ $category }} 
                </a> @empty <span class="block py-2 text-gray-400">No men categories</span> 
                @endforelse </div>
             </div>
                 <a href="{{ route('frontend.fragrances') }}" class="block py-4 border-b">Fragrances</a> 
                 <a href="{{ route('frontend.brands') }}" class="block py-4 border-b">Brands</a> </div> 
                </div>
             </div>
             {{-- ================= PAGE CONTENT ================= --}}
@yield('content')

{{-- ================= LOGIN DRAWER ================= --}}

<!-- Overlay -->
<div id="loginOverlay"
     class="fixed inset-0 bg-black/60 z-[9998] hidden"
     onclick="closeLoginDrawer()">
</div>

<!-- Drawer -->
<div id="loginDrawer"
     class="fixed top-0 right-0 h-full w-full sm:w-[430px] bg-white z-[9999] translate-x-full transition-transform duration-300 overflow-y-auto">

    <div class="px-5 sm:px-7 py-6 sm:py-7">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-[22px] font-bold text-black">
                Login
            </h2>

            <button type="button"
                    onclick="closeLoginDrawer()"
                    class="text-3xl leading-none text-black">
                &times;
            </button>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 text-xs">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Message -->
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 text-xs">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('customer.login.submit') }}">
            @csrf

            <div class="mb-5">
                <label class="block text-[15px] font-medium mb-2">
                    Email Address
                    <span class="text-red-500">*</span>
                </label>

                <input type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       class="w-full h-[52px] border border-gray-300 px-4 text-[15px] outline-none focus:border-black">
            </div>

            <div class="mb-5">
                <label class="block text-[15px] font-medium mb-2">
                    Password
                    <span class="text-red-500">*</span>
                </label>

                <input type="password"
                       name="password"
                       required
                       class="w-full h-[52px] border border-gray-300 px-4 text-[15px] outline-none focus:border-black">
            </div>

            <button type="submit"
                    class="w-full h-[50px] bg-[#222] text-white text-[15px] font-semibold uppercase">
                Log In
            </button>

            <div class="text-center mt-5">
                <a href="{{ route('customer.password.request') }}"
                   class="text-[15px] underline text-black">
                    Forgot your password?
                </a>
            </div>

            <a href="{{ route('customer.register') }}"
               class="mt-6 w-full h-[50px] border border-gray-500 flex items-center justify-center text-[15px] uppercase text-black">
                Create Account
            </a>

        </form>

    </div>

</div>

{{-- ================= CUSTOMER DRAWER ================= --}}

<!-- Overlay -->
<div id="customerOverlay"
     class="fixed inset-0 bg-black/60 z-[9998] hidden"
     onclick="closeCustomerDrawer()">
</div>

<!-- Drawer -->
<div id="customerDrawer"
     class="fixed top-0 right-0 h-full w-full sm:w-[430px] bg-white z-[9999] translate-x-full transition-transform duration-300 overflow-y-auto">

    <div class="px-6 sm:px-8 py-7">

        <!-- Header -->
        <div class="flex items-center justify-between mb-12">

            <h2 class="text-[24px] font-bold text-black">
                Hi,
                {{ auth()->check() ? (auth()->user()->name ?? auth()->user()->email) : 'Customer' }}
            </h2>

            <button type="button"
                    onclick="closeCustomerDrawer()"
                    class="text-3xl leading-none text-black">
                &times;
            </button>

        </div>

        <!-- Menu -->
        <div class="space-y-0 text-[17px] text-[#222]">

            <a href="{{ route('customer.password.request') }}"
               class="block py-4 border-b border-gray-300">
                Reset Your Password
            </a>

            <form method="POST" action="{{ route('customer.logout') }}">
                @csrf

                <button type="submit"
                        class="w-full text-left py-4">
                    Log Out
                </button>
            </form>

        </div>

    </div>

</div>

{{-- ================= NEWSLETTER ================= --}}

<section class="bg-gray-100 py-10">

    <div class="max-w-7xl mx-auto px-6 text-center">

        <h2 class="text-2xl font-semibold text-gray-900 mb-2">
            Subscribe on our newsletter
        </h2>

        <p class="text-gray-600 mb-6 text-sm">
            Sign up for exclusive updates, new arrivals & insider only discounts
        </p>

        <div class="flex justify-center max-w-lg mx-auto">

            <div class="flex flex-col sm:flex-row w-full border border-gray-300 rounded-lg overflow-hidden shadow-sm">

                <div class="flex-1 flex items-center bg-white px-5 py-4">

                    <i class="fas fa-envelope text-gray-400 text-lg"></i>

                    <input type="email"
                           placeholder="Enter your email address"
                           class="flex-1 ml-4 outline-none text-sm text-gray-700 placeholder-gray-400">

                </div>

                <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 sm:py-0 font-medium text-sm">
                    Subscribe
                </button>

            </div>

        </div>

    </div>

</section>
<footer class="bg-white border-t pt-10 pb-8">

    <div class="max-w-7xl mx-auto px-6">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8">

            <!-- Brand -->
            <div class="lg:col-span-4">
                <span class="text-3xl font-bold tracking-tighter text-black">
                    Imran Cloth House
                </span>
            </div>

            <!-- Information -->
            <div class="lg:col-span-2">
                <h3 class="font-semibold text-sm mb-3 text-gray-900">
                    INFORMATION
                </h3>

                <ul class="space-y-2 text-xs text-gray-600">
                    <li>
                        <a href="{{ route('about') }}" class="hover:text-black">
                            About Us
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('contact') }}" class="hover:text-black">
                            Contact Us
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('store.locator') }}" class="hover:text-black">
                            Store Locator
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Policies -->
            <div class="lg:col-span-3">
                <h3 class="font-semibold text-sm mb-3 text-gray-900">
                    POLICIES
                </h3>

                <ul class="space-y-2 text-xs text-gray-600">

                    <li>
                        <a href="{{ route('exchange.refund') }}" class="hover:text-black">
                            Exchange And Refund Policy
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('terms') }}" class="hover:text-black">
                            Terms And Conditions
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('shipping.policy') }}" class="hover:text-black">
                            Shipping Policy
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('privacy.policy') }}" class="hover:text-black">
                            Privacy Policy
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('faq') }}" class="hover:text-black">
                            FAQs
                        </a>
                    </li>

                </ul>
            </div>

            <!-- Customer Service -->
            <div class="lg:col-span-3">
                <h3 class="font-semibold text-sm mb-3 text-gray-900">
                    CUSTOMER SERVICE
                </h3>

                <ul class="space-y-2 text-xs text-gray-600">
                    <li>Email: info.imranclothhouse@gmail.com</li>
                    <li>Mon - Sat: 1:00 PM to 10:00 PM</li>
                    <li>Call & Complaints: 0337-6746555</li>
                </ul>
            </div>

        </div>

        <!-- Copyright -->
        <div class="mt-10 pt-6 border-t text-center text-xs text-gray-500">

            <p>
                © {{ date('Y') }} Imran Cloth House. All Rights Reserved.
            </p>

            <div class="mt-2">
                Powered by
                <a href="https://www.sharplite.com"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="font-semibold tracking-wide text-gray-700 hover:text-black transition">
                    Sharplite
                </a>
            </div>

        </div>

    </div>

</footer>
<!-- ================= WHATSAPP FLOATING BUTTON ================= -->
<a href="https://wa.me/923376746555"
   target="_blank"
   class="fixed bottom-6 right-6 z-[9999] group">

    <!-- Pulse Effect -->
    <span class="absolute inset-0 rounded-full bg-green-400 animate-ping opacity-20"></span>

    <!-- Main Button -->
    <div class="flex items-center gap-3 bg-[#25D366] hover:bg-[#20ba5a] text-white px-5 py-3 rounded-full shadow-2xl transition-all duration-300 hover:scale-105">

        <!-- WhatsApp Icon -->
        <div class="flex items-center justify-center w-10 h-10 bg-white rounded-full">
            <i class="fa-brands fa-whatsapp text-[#25D366] text-2xl"></i>
        </div>

        <!-- Text -->
        <div class="leading-tight">
            <span class="block font-semibold text-lg">
                Chat with us
            </span>
        </div>

    </div>

</a>
<!-- ================= END WHATSAPP BUTTON ================= -->
<script>
    function openMobileMenu() {
        document.getElementById('mobileMenuOverlay').classList.remove('hidden');
        document.getElementById('mobileMenuDrawer').classList.remove('-translate-x-full');
        document.body.classList.add('overflow-hidden');
    }

    function closeMobileMenu() {
        document.getElementById('mobileMenuOverlay').classList.add('hidden');
        document.getElementById('mobileMenuDrawer').classList.add('-translate-x-full');
        document.body.classList.remove('overflow-hidden');
    }

    function openLoginDrawer() {
        document.getElementById('loginOverlay').classList.remove('hidden');
        document.getElementById('loginDrawer').classList.remove('translate-x-full');
        document.body.classList.add('overflow-hidden');
    }

    function closeLoginDrawer() {
        document.getElementById('loginOverlay').classList.add('hidden');
        document.getElementById('loginDrawer').classList.add('translate-x-full');
        document.body.classList.remove('overflow-hidden');
    }

    function openCustomerDrawer() {
        document.getElementById('customerOverlay').classList.remove('hidden');
        document.getElementById('customerDrawer').classList.remove('translate-x-full');
        document.body.classList.add('overflow-hidden');
    }

    function closeCustomerDrawer() {
        document.getElementById('customerOverlay').classList.add('hidden');
        document.getElementById('customerDrawer').classList.add('translate-x-full');
        document.body.classList.remove('overflow-hidden');
    }

    function toggleMobileDropdown(id) {
        document.getElementById(id).classList.toggle('hidden');
    }
</script>

@stack('scripts')
</body>
</html>