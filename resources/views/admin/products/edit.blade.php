@extends('layouts.admin')

@section('title', 'Edit Product')
@section('page_title', 'Edit Product')

@section('content')

<div class="max-w-6xl mx-auto">

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-2xl mb-6">
{{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-2xl mb-6">

<ul class="list-disc list-inside">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>
@endif


<form method="POST"
action="{{ route('admin.products.update',$product->id) }}"
enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

<!-- LEFT -->

<div class="lg:col-span-5 space-y-6">

<div class="bg-white rounded-3xl p-6 border">

<h3 class="font-semibold mb-4">
Product Photos
</h3>

@if($product->images && count($product->images))

<div class="grid grid-cols-3 gap-3 mb-5">

@foreach($product->images as $img)

<img src="{{ asset($img) }}"
class="w-full h-28 object-cover rounded-xl border">

@endforeach

</div>

@endif

<div id="drop-zone"
class="border-2 border-dashed border-gray-300 rounded-2xl h-72 flex flex-col items-center justify-center cursor-pointer">

<i class="fa-solid fa-cloud-arrow-up text-5xl text-gray-300 mb-4"></i>

<p>Click To Upload Images</p>

<input type="file"
id="image-input"
name="images[]"
multiple
class="hidden">

</div>

<div id="image-preview"
class="grid grid-cols-3 gap-3 mt-4">
</div>

</div>


<div class="bg-white rounded-3xl p-6 border">

<h3 class="font-semibold mb-5">
Pricing Details
</h3>

<div class="grid grid-cols-2 gap-6">

<div>

<label class="block text-xs mb-1">
Regular Price
</label>

<input type="number"
name="price"
step="0.01"
value="{{ old('price',$product->price) }}"
class="w-full border rounded-2xl px-5 py-3">

</div>


<div>

<label class="block text-xs mb-1">
Discount Price
</label>

<input type="number"
name="discount_price"
step="0.01"
value="{{ old('discount_price',$product->discount_price) }}"
class="w-full border rounded-2xl px-5 py-3">

</div>

</div>

</div>

</div>

<!-- RIGHT -->

<div class="lg:col-span-7 space-y-6">

<div class="bg-white rounded-3xl p-6 border">

<h3 class="font-semibold mb-6">

Product Information

</h3>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

<div>

<label>Product Name</label>

<input type="text"
name="name"
value="{{ old('name',$product->name) }}"
class="w-full border rounded-2xl px-5 py-3">

</div>


<div>

<label>Product ID</label>

<input type="text"
name="product_id"
value="{{ old('product_id',$product->product_id) }}"
class="w-full border rounded-2xl px-5 py-3">

</div>

</div>


<div class="mt-6">

<label>Brand</label>

<select name="brand"
class="w-full border rounded-2xl px-5 py-3">

<option value="">
Select Brand
</option>

@foreach(App\Models\Brand::where('is_active',true)->get() as $brand)

<option value="{{ $brand->name }}"
{{ old('brand',$product->brand)==$brand->name ? 'selected':'' }}>

{{ $brand->name }}

</option>

@endforeach

</select>

</div>


<div class="mt-8 border-t pt-8">

<h4 class="font-semibold mb-4">

Description & Attributes

</h4>

<textarea
name="description"
rows="5"
class="w-full border rounded-2xl px-5 py-3">{{ old('description',$product->description) }}</textarea>


<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

<div>

<label>Outfit Type</label>

<select
name="outfit_type_id"
class="w-full border rounded-2xl px-5 py-3">

<option value="">
Select Outfit Type
</option>

@foreach(App\Models\Attribute::ofType('outfit_type')->get() as $attr)

<option value="{{ $attr->id }}"
{{ old('outfit_type_id',$product->outfit_type_id)==$attr->id ? 'selected':'' }}>

{{ $attr->name }}

</option>

@endforeach

</select>

</div>


<div>

<label>Color Type</label>

<select
name="color_type"
id="color-select"
class="w-full border rounded-2xl px-5 py-3">

<option value="">
Select Color
</option>

<option value="Custom">
Custom Color
</option>

@foreach(App\Models\Attribute::ofType('color_type')->get() as $attr)

<option value="{{ $attr->name }}"
{{ old('color_type',$product->color_type)==$attr->name ? 'selected':'' }}>

{{ $attr->name }}

</option>

@endforeach

</select>

<input type="text"
name="color_type_custom"
id="custom-color"
value="{{ old('color_type_custom',$product->color_type_custom) }}"
class="hidden mt-2 w-full border rounded-2xl px-5 py-3">

</div>

</div>

</div>


<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">

<div>

<label>Category</label>

<select name="category"
class="w-full border rounded-2xl px-5 py-3">

@foreach(App\Models\Category::where('is_active',true)->get() as $cat)

<option value="{{ $cat->name }}"
{{ old('category',$product->category)==$cat->name ? 'selected':'' }}>

{{ $cat->name }}

</option>

@endforeach

</select>

</div>


<div>

<label>Gender</label>

<select name="gender"
class="w-full border rounded-2xl px-5 py-3">

<option value="Women"
{{ $product->gender=='Women'?'selected':'' }}>
Women
</option>

<option value="Men"
{{ $product->gender=='Men'?'selected':'' }}>
Men
</option>



</select>

</div>


<div>

<label>Stock</label>

<input type="number"
name="stock"
value="{{ old('stock',$product->stock) }}"
class="w-full border rounded-2xl px-5 py-3">

</div>

</div>

</div>


<div class="flex justify-end gap-4">

<a href="{{ route('admin.products.index') }}"
class="px-8 py-3 border rounded-2xl">

Cancel

</a>

<button class="px-10 py-3 bg-orange-500 text-white rounded-2xl">

Update Product

</button>

</div>

</div>

</div>

</form>

</div>

@endsection