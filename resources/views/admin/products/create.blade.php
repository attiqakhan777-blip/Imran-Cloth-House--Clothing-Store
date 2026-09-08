@extends('layouts.admin')

@section('title', 'Create Product')
@section('page_title', 'Create Product')

@section('content')
<div class="max-w-6xl mx-auto">

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-2xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-2xl mb-6">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-8" id="product-form">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <div class="lg:col-span-5 space-y-6">

                <div class="bg-white rounded-3xl p-6 border">
                    <h3 class="font-semibold mb-4">Product Photos (Max 5 images)</h3>

                    <div id="drop-zone" class="border-2 border-dashed border-gray-300 rounded-2xl h-72 flex flex-col items-center justify-center text-center cursor-pointer hover:border-amber-400 transition">
                        <i class="fa-solid fa-cloud-arrow-up text-5xl text-gray-300 mb-4"></i>
                        <p class="font-medium">Drop images here or</p>
                        <p class="text-amber-600 font-medium">click to browse</p>
                        <input type="file" id="image-input" name="images[]" multiple accept="image/*" class="hidden">
                        <p class="text-xs text-gray-400 mt-6">1600×1200 recommended • Max 5 images</p>
                    </div>

                    <div id="image-preview" class="mt-4 grid grid-cols-3 gap-3"></div>
                </div>

                <div class="bg-white rounded-3xl p-6 border">
                    <h3 class="font-semibold mb-5">Pricing Details</h3>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="text-xs text-gray-500 block mb-1">Regular Price (Rs.)</label>
                            <input type="number" name="price" step="0.01" class="w-full border border-gray-300 rounded-2xl px-5 py-3" placeholder="19950" required>
                        </div>

                        <div>
                            <label class="text-xs text-gray-500 block mb-1">Sale / Discount Price (Rs.)</label>
                            <input type="number" name="discount_price" step="0.01" class="w-full border border-gray-300 rounded-2xl px-5 py-3" placeholder="14950">
                        </div>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-7 space-y-6">

                <div class="bg-white rounded-3xl p-6 border">
                    <h3 class="font-semibold mb-6">Product Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-xs text-gray-500 block mb-1">Product Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" class="w-full border border-gray-300 rounded-2xl px-5 py-3" required>
                        </div>

                        <div>
                            <label class="text-xs text-gray-500 block mb-1">Product ID <span class="text-red-500">*</span></label>

                            <div class="flex gap-2">
                                <input type="text" name="product_id" id="product_id"
                                       class="w-full border border-gray-300 rounded-2xl px-5 py-3"
                                       placeholder="LIB-20250508-001" required>

                                <button type="button" onclick="generateProductId()"
                                        class="px-6 py-3 bg-gray-800 hover:bg-gray-900 text-white rounded-2xl text-sm font-medium whitespace-nowrap">
                                    Generate ID
                                </button>
                            </div>

                            <small class="text-gray-500 mt-1 block">Click "Generate ID" for automatic unique ID</small>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="text-xs text-gray-500 block mb-1">Brand Name</label>

                        <select name="brand" id="brand-select"
                                class="w-full border border-gray-300 rounded-2xl px-5 py-3 focus:ring-2 focus:ring-orange-500">
                            <option value="">Select Brand</option>

                            @foreach(App\Models\Brand::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get() as $brand)
                                <option value="{{ $brand->name }}" {{ old('brand') == $brand->name ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach

                            <option value="custom">Add Custom Brand</option>
                        </select>

                        <input type="text" id="custom-brand" name="brand_custom"
                               class="w-full border border-gray-300 rounded-2xl px-5 py-3 mt-2 hidden"
                               placeholder="Enter new brand name">
                    </div>

                    <div class="mt-8 border-t pt-8">
                        <h4 class="font-semibold mb-4">Description & Attributes</h4>

                        <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-2xl px-5 py-3" placeholder="Write full product description..."></textarea>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                            <div>
                                <label class="text-xs text-gray-500 block mb-1">Outfit Type <span class="text-red-500">*</span></label>
                                <select name="outfit_type_id" class="w-full border border-gray-300 rounded-2xl px-5 py-3" required>
                                    <option value="">Select Outfit Type</option>

                                    @foreach(App\Models\Attribute::ofType('outfit_type')->get() as $attr)
                                        <option value="{{ $attr->id }}" {{ old('outfit_type_id') == $attr->id ? 'selected' : '' }}>
                                            {{ $attr->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="text-xs text-gray-500 block mb-1">Color Type</label>
                                <select name="color_type" id="color-select" class="w-full border border-gray-300 rounded-2xl px-5 py-3">
                                    <option value="">Select Color Type</option>
                                    <option value="Custom" {{ old('color_type') == 'Custom' ? 'selected' : '' }}>Custom Color</option>

                                    @foreach(App\Models\Attribute::ofType('color_type')->get() as $attr)
                                        <option value="{{ $attr->name }}" {{ old('color_type') == $attr->name ? 'selected' : '' }}>
                                            {{ $attr->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <input type="text" id="custom-color" name="color_type_custom"
                                       class="w-full border border-gray-300 rounded-2xl px-5 py-3 mt-2 hidden"
                                       placeholder="Enter custom color"
                                       value="{{ old('color_type_custom') }}">
                            </div>

                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                        <div>
                            <label class="text-xs text-gray-500 block mb-1">Category <span class="text-red-500">*</span></label>
                            <select name="category" class="w-full border border-gray-300 rounded-2xl px-5 py-3" required>
                                <option value="">Select Category</option>

                                @foreach(\App\Models\Category::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get() as $cat)
                                    <option value="{{ $cat->name }}" {{ old('category') == $cat->name ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-xs text-gray-500 block mb-1">Gender</label>
                            <select name="gender" class="w-full border border-gray-300 rounded-2xl px-5 py-3">
                                <option value="">Select Gender</option>
                                <option value="Women">Women</option>
                                <option value="Men">Men</option>
                                
                            </select>
                        </div>

                        <div>
                            <label class="text-xs text-gray-500 block mb-1">Stock</label>
                            <input type="number" name="stock" class="w-full border border-gray-300 rounded-2xl px-5 py-3" min="0" required>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <button type="button" onclick="history.back()" class="px-8 py-3 border border-gray-300 rounded-2xl">
                        Cancel
                    </button>

                    <button type="submit" class="px-10 py-3 bg-orange-500 text-white rounded-2xl hover:bg-orange-600">
                        Create Product
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('image-input');
    const preview = document.getElementById('image-preview');
    const colorSelect = document.getElementById('color-select');
    const customColor = document.getElementById('custom-color');
    const brandSelect = document.getElementById('brand-select');
    const customBrand = document.getElementById('custom-brand');

    dropZone.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', function() {
        preview.innerHTML = '';

        Array.from(this.files).slice(0, 5).forEach(file => {
            const reader = new FileReader();

            reader.onload = function(e) {
                const div = document.createElement('div');
                div.innerHTML = `<img src="${e.target.result}" class="w-full h-28 object-cover rounded-xl border">`;
                preview.appendChild(div);
            };

            reader.readAsDataURL(file);
        });
    });

    if (colorSelect && customColor) {
        colorSelect.addEventListener('change', function() {
            if (this.value === 'Custom') {
                customColor.classList.remove('hidden');
                customColor.required = true;
            } else {
                customColor.classList.add('hidden');
                customColor.required = false;
            }
        });
    }

    if (brandSelect && customBrand) {
        brandSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customBrand.classList.remove('hidden');
                customBrand.required = true;
            } else {
                customBrand.classList.add('hidden');
                customBrand.required = false;
            }
        });
    }

    if (!document.getElementById('product_id').value.trim()) {
        generateProductId();
    }
});

function generateProductId() {
    const prefix = "LIB";
    const date = new Date();
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const random = Math.floor(1000 + Math.random() * 9000);

    document.getElementById('product_id').value = `${prefix}-${year}${month}${day}-${random}`;
}
</script>