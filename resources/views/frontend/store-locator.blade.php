@extends('layouts.app')

@section('title', 'Store Locator')
@section('meta_description', 'Find Imran Cloth House store location, shop timings, contact number, and clothing shop details.')
@section('meta_keywords', 'Imran Cloth House store, store locator, clothing shop location, fabric shop near me, unstitched clothes shop')

@section('content')

<section class="w-full bg-white">

    <div class="w-full bg-gray-100 py-12 sm:py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900">
                Store Locator
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-gray-600 text-sm sm:text-base">
                Visit our shop for quality unstitched clothes and fabric variety.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-stretch">

            <div class="bg-gray-50 border rounded-3xl p-6 sm:p-8 lg:p-10">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6">
                    Imran Cloth House
                </h2>

                <div class="space-y-5 text-sm sm:text-base text-gray-700">
                    <div class="flex gap-4">
                        <i class="fa-solid fa-location-dot text-black mt-1"></i>
                        <div>
                            <h3 class="font-bold text-black">Address</h3>
                            <p>Main Sadiq Bazar, Rahim Yar Khan</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <i class="fa-solid fa-phone text-black mt-1"></i>
                        <div>
                            <h3 class="font-bold text-black">Phone</h3>
                            <p>0337-6746555</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <i class="fa-solid fa-envelope text-black mt-1"></i>
                        <div>
                            <h3 class="font-bold text-black">Email</h3>
                            <p class="break-all">info.imranclothhouse@gmail.com</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <i class="fa-solid fa-clock text-black mt-1"></i>
                        <div>
                            <h3 class="font-bold text-black">Timings</h3>
                            <p>Mon - Sat: 1:00 PM to 10:00 PM</p>
                        </div>
                    </div>
                </div>

               
            </div>

            <div class="rounded-3xl overflow-hidden border shadow-sm min-h-[350px] sm:min-h-[450px]">
                <iframe
                    src="https://www.google.com/maps?q=Pakistan&output=embed"
                    width="100%"
                    height="100%"
                    style="border:0; min-height:450px;"
                    allowfullscreen=""
                    loading="lazy">
                </iframe>
            </div>

        </div>
    </div>

</section>

@endsection