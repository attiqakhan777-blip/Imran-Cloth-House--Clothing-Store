
text/x-generic list.blade.php ( HTML document, ASCII text, with CRLF line terminators )
@extends('layouts.admin')

@section('title', 'Product List')
@section('page_title', 'Product List')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h1 class="text-2xl font-semibold">All Products</h1>
        
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full sm:w-auto">
            <form method="GET" action="{{ route('admin.products.index') }}" class="relative w-full sm:w-80">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search by name, ID..." 
                       class="w-full border border-gray-300 rounded-2xl pl-10 pr-4 py-3 text-sm focus:outline-none focus:border-amber-500">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-3.5 text-gray-400"></i>
            </form>

            <a href="{{ route('admin.products.create') }}" 
               class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-2xl text-sm font-medium flex items-center gap-2 whitespace-nowrap">
                <i class="fa-solid fa-plus"></i> Add New Product
            </a>
        </div>
    </div>

    <!-- Bulk Discount Form -->
    <form id="bulk-discount-form" method="POST" action="{{ route('admin.products.bulk-discount') }}" class="bg-white p-5 rounded-3xl shadow mb-6">
        @csrf
        <div class="flex flex-wrap items-center gap-4 text-sm">
            <span class="font-medium text-gray-700">Bulk Discount:</span>
            
            <select name="discount_type" class="border border-gray-300 rounded-2xl px-4 py-2.5 text-sm">
                <option value="percentage">Percentage Off (%)</option>
                <option value="fixed">Fixed Amount (Rs)</option>
            </select>

            <input type="number" name="discount_value" step="0.01" placeholder="20" 
                   class="border border-gray-300 rounded-2xl px-4 py-2.5 w-28 text-sm" required>

            <button type="submit" onclick="return applyBulkDiscount()" 
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-2xl font-medium text-sm">
                Apply Discount
            </button>
        </div>
    </form>

    <form id="bulk-delete-form" method="POST" action="{{ route('admin.products.bulk-delete') }}">
        @csrf
        @method('DELETE')

        <div class="bg-white rounded-3xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px] text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="w-12 p-4">
                                <input type="checkbox" id="select-all">
                            </th>
                            <th class="text-left p-4">Product</th>
                            <th class="text-left p-4">Product ID</th>
                            <th class="text-left p-4">Price</th>
                            <th class="text-left p-4">Discount Price</th>
                            <th class="text-left p-4">Discount %</th>
                            <th class="text-left p-4">Stock</th>
                            <th class="text-center p-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="p-4">
                                <input type="checkbox" name="ids[]" value="{{ $product->id }}" class="product-checkbox">
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-4">
                                    <img src="{{ asset($product->images[0] ?? 'https://via.placeholder.com/60') }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-14 h-14 object-cover rounded-xl border">
                                    <div class="font-medium text-sm">{{ $product->name }}</div>
                                </div>
                            </td>
                            <td class="p-4 font-mono text-sm">{{ $product->product_id ?? 'N/A' }}</td>
                            <td class="p-4 font-semibold text-sm">Rs. {{ number_format($product->price) }}</td>
                            
                            <td class="p-4 text-sm">
                                @if($product->discount_price)
                                    <span class="text-orange-600 font-semibold">Rs. {{ number_format($product->discount_price) }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="p-4 text-sm">
                                @if($product->discount_price && $product->price > 0)
                                    @php
                                        $discountPercent = round((($product->price - $product->discount_price) / $product->price) * 100, 1);
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        -{{ $discountPercent }}%
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>

                            <td class="p-4 text-sm">
                                <span class="{{ ($product->stock ?? 0) > 10 ? 'text-green-600' : 'text-red-600' }} font-medium">
                                    {{ $product->stock ?? 0 }}
                                </span>
                            </td>

                            <td class="p-4 text-center">
                                <div class="flex justify-center gap-3">
                                    <a href="{{ route('product.detail', $product->slug) }}" target="_blank" 
                                       class="p-2 hover:bg-gray-100 rounded-xl text-blue-600">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="p-2 hover:bg-gray-100 rounded-xl text-amber-600">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="p-16 text-center text-gray-500">No products found.</td>
                        </tr>
                        @endempty
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bulk Delete -->
        <div class="mt-4 flex justify-end">
            <button type="submit" onclick="return confirm('Delete selected products?')" 
                    class="bg-red-600 text-white px-6 py-3 rounded-2xl text-sm font-medium flex items-center gap-2">
                <i class="fa-solid fa-trash"></i> Delete Selected
            </button>
        </div>
    </form>
</div>
@endsection

<script>
// Select All
document.getElementById('select-all').addEventListener('change', function() {
    document.querySelectorAll('.product-checkbox').forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Bulk Discount
function applyBulkDiscount() {
    const selected = Array.from(document.querySelectorAll('.product-checkbox:checked'))
                         .map(cb => cb.value);

    if (selected.length === 0) {
        alert("Please select at least one product!");
        return false;
    }

    const form = document.getElementById('bulk-discount-form');
    form.querySelectorAll('input[name="product_ids[]"]').forEach(el => el.remove());

    selected.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'product_ids[]';
        input.value = id;
        form.appendChild(input);
    });

    return true;
}
</script>