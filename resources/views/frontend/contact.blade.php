
text/x-generic contact.blade.php ( HTML document, ASCII text, with CRLF line terminators )
@extends('layouts.app')

@section('title', 'Contact Us')
@section('meta_description', 'Contact Imran Cloth House for clothing orders, fabric information, complaints, and customer support.')
@section('meta_keywords', 'Contact Imran Cloth House, clothing store contact, fabric shop phone number, unstitched clothes support')

@section('content')

<section class="w-full bg-white">

    <div class="w-full bg-gray-100 py-12 sm:py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900">
                Contact Us
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-gray-600 text-sm sm:text-base">
                Need help? Contact our customer support team.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="bg-gray-50 border rounded-3xl p-6 sm:p-8">
                <i class="fa-solid fa-phone text-3xl text-black mb-5"></i>
                <h3 class="text-xl font-bold mb-2">Call Us</h3>
                <p class="text-gray-600 text-sm mb-4">For orders and complaints</p>
                <a href="tel:03376746555" class="font-semibold text-black">
                    0337-6746555
                </a>
            </div>

            <div class="bg-gray-50 border rounded-3xl p-6 sm:p-8">
                <i class="fa-solid fa-envelope text-3xl text-black mb-5"></i>
                <h3 class="text-xl font-bold mb-2">Email Us</h3>
                <p class="text-gray-600 text-sm mb-4">Send your query anytime</p>
                <a href="mailto:info.imranclothhouse@gmail.com" class="font-semibold text-black break-all">
                    info.imranclothhouse@gmail.com
                </a>
            </div>

            <div class="bg-gray-50 border rounded-3xl p-6 sm:p-8">
                <i class="fa-solid fa-clock text-3xl text-black mb-5"></i>
                <h3 class="text-xl font-bold mb-2">Timings</h3>
                <p class="text-gray-600 text-sm mb-4">Shop opening hours</p>
                <p class="font-semibold text-black">
                    Mon - Sat: 1:00 PM to 10:00 PM
                </p>
            </div>

        </div>

        
    </div>

</section>

@endsection