@extends('layouts.admin')

@section('title', 'Website Settings')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-8 rounded-3xl">

    <h1 class="text-3xl font-bold mb-8">
        Checkout Charges Settings
    </h1>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">

        @csrf

        <div class="mb-6">
            <label class="block mb-2 font-medium">
                Shipping Charges
            </label>

            <input
                type="number"
                name="shipping_charges"
                value="{{ $setting->shipping_charges }}"
                class="w-full border rounded-xl px-4 h-12"
            >
        </div>

        <div class="mb-6">
            <label class="block mb-2 font-medium">
                Tax Charges
            </label>

            <input
                type="number"
                name="tax_charges"
                value="{{ $setting->tax_charges }}"
                class="w-full border rounded-xl px-4 h-12"
            >
        </div>

        <div class="mb-6">
            <label class="block mb-2 font-medium">
                Handling Charges
            </label>

            <input
                type="number"
                name="handling_charges"
                value="{{ $setting->handling_charges }}"
                class="w-full border rounded-xl px-4 h-12"
            >
        </div>

        <button class="bg-black text-white px-8 h-12 rounded-xl">
            Save Settings
        </button>

    </form>

</div>

@endsection