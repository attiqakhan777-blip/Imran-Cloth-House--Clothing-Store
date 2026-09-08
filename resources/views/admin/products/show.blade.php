@extends('layouts.admin')

@section('title', 'View Product')
@section('page_title', 'View Product')

@section('content')

<div class="max-w-5xl mx-auto">

<div class="bg-white rounded-3xl shadow-sm p-8">

<div class="flex justify-between items-start">

<div>

<h1 class="text-3xl font-bold">
{{ $product->name }}
</h1>

<p class="text-gray-500">

Product ID:

<span class="font-mono font-medium">

{{ $product->product_id }}

</span>

</p>

</div>

<a href="{{ route('admin.products.edit',$product) }}"
class="bg-amber-500 hover:bg-amber-600 text-white px-6 py-3 rounded-2xl">

Edit Product

</a>

</div>


<div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mt-10">

<!-- Images -->

<div>

<h3 class="font-semibold mb-4 text-lg">

Product Photos

</h3>

@if($product->images && count($product->images))

<div class="grid grid-cols-2 gap-4">

@foreach($product->images as $img)

<img src="{{ asset($img) }}"
class="rounded-2xl border shadow-sm">

@endforeach

</div>

@else

<p class="text-gray-400">

No images available

</p>

@endif

</div>


<!-- DETAILS -->

<div class="space-y-8">

<!-- PRICE -->

<div>

<h3 class="font-semibold mb-3">

Pricing

</h3>

<div class="flex items-center gap-4">

<span class="text-4xl font-bold">

Rs. {{ number_format($product->price ?? 0) }}

</span>

@if($product->discount_price)

<span class="line-through text-gray-400">

Rs. {{ number_format($product->discount_price) }}

</span>

@endif

</div>

</div>


<!-- BASIC INFO -->

<div>

<h3 class="font-semibold mb-3">

Basic Information

</h3>

<div class="grid grid-cols-2 gap-y-4 text-sm">

<div>

<span class="text-gray-500">

Category:

</span>

<strong>

{{ $product->category ?? 'N/A' }}

</strong>

</div>


<div>

<span class="text-gray-500">

Gender:

</span>

<strong>

{{ $product->gender ?? 'N/A' }}

</strong>

</div>


<div>

<span class="text-gray-500">

Brand:

</span>

<strong>

{{ $product->brand ?? 'N/A' }}

</strong>

</div>


<div>

<span class="text-gray-500">

Stock:

</span>

<strong class="text-green-600">

{{ $product->stock ?? 0 }}

Left

</strong>

</div>

</div>

</div>


<!-- ATTRIBUTES -->

<div>

<h3 class="font-semibold mb-3">

Product Attributes

</h3>

<div class="grid grid-cols-2 gap-y-4 text-sm">

<div>

<span class="text-gray-500">

Outfit Type:

</span>

<strong>

{{ $product->outfitType?->name ?? 'N/A' }}

</strong>

</div>


<div>

<span class="text-gray-500">

Style:

</span>

<strong>

{{ $product->style?->name ?? 'N/A' }}

</strong>

</div>


<div>

<span class="text-gray-500">

Color Type:

</span>

<strong>

{{ $product->color_type ?? 'N/A' }}

</strong>

</div>

</div>

</div>


<!-- DESCRIPTION -->

<div>

<h3 class="font-semibold mb-2">

Description

</h3>

<p class="text-gray-600 whitespace-pre-wrap">

{{ $product->description ?? 'No description provided.' }}

</p>

</div>

</div>

</div>

</div>

</div>

@endsection