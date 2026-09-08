
text/x-generic about.blade.php ( ASCII text, with CRLF line terminators )
@extends('layouts.app')

@section('title', 'About Us')
@section('meta_description', 'Learn about Imran Cloth House, a trusted clothing brand working since 1990, offering quality unstitched clothes and fabric variety.')
@section('meta_keywords', 'About Imran Cloth House, clothing brand since 1990, unstitched clothes, fabric shop, Pakistani clothing brand')

@section('content')

<section class="w-full bg-white">

    <div class="w-full bg-gray-100 py-12 sm:py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900">
                About Imran Cloth House
            </h1>
            <p class="mt-4 max-w-3xl mx-auto text-gray-600 text-sm sm:text-base leading-7">
                Serving quality unstitched clothes and fabric variety since 1990.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14 items-center">

            <div>
                <img src="{{ asset('images/1.jpg') }}"
                     alt="Imran Cloth House Shop"
                     class="w-full h-[300px] sm:h-[420px] lg:h-[520px] object-cover rounded-3xl shadow-lg">
            </div>

            <div>
                <span class="text-sm font-semibold tracking-widest text-gray-500 uppercase">
                    Since 1990
                </span>

                <h2 class="mt-3 text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 leading-tight">
                    Trusted Clothing Store for Quality Fabrics
                </h2>

                <p class="mt-5 text-gray-600 text-sm sm:text-base leading-8">
                    Imran Cloth House is a clothing brand providing quality unstitched clothes with different varieties for customers who love comfort, style, and reliable fabric quality.
                </p>

                <p class="mt-4 text-gray-600 text-sm sm:text-base leading-8">
                    Since 1990, we have worked to provide beautiful clothing options for women, men, and families. Our goal is to make shopping simple, trusted, and affordable.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8">
                    <div class="bg-gray-50 p-5 rounded-2xl border">
                        <h3 class="text-2xl font-bold text-black">1990</h3>
                        <p class="text-xs text-gray-500 mt-1">Working Since</p>
                    </div>

                    <div class="bg-gray-50 p-5 rounded-2xl border">
                        <h3 class="text-2xl font-bold text-black">100%</h3>
                        <p class="text-xs text-gray-500 mt-1">Quality Focus</p>
                    </div>

                    <div class="bg-gray-50 p-5 rounded-2xl border">
                        <h3 class="text-2xl font-bold text-black">Many</h3>
                        <p class="text-xs text-gray-500 mt-1">Fabric Varieties</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</section>

@endsection