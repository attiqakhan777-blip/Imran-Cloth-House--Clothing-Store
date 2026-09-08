@extends('layouts.admin')

@section('title', 'Edit Brand - ' . ($brand->name ?? ''))

@section('content')
<div class="p-6">
    <div class="max-w-2xl mx-auto">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Edit Brand</h1>
            <a href="{{ route('admin.brands.index') }}" 
               class="px-5 py-2 text-gray-600 hover:text-black">← Back to Brands</a>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-2xl mb-6">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.brands.update', $brand) }}" method="POST" class="bg-white rounded-3xl p-8 shadow">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Brand Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $brand->name) }}" 
                           class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:outline-none focus:border-orange-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Slug</label>
                    <input type="text" value="{{ $brand->slug }}" 
                           class="w-full border border-gray-300 rounded-2xl px-5 py-4 bg-gray-100 cursor-not-allowed" readonly>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Description</label>
                    <textarea name="description" rows="4" 
                              class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:outline-none focus:border-orange-500">{{ old('description', $brand->description) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $brand->sort_order) }}" 
                               class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Status</label>
                        <select name="is_active" class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                            <option value="1" {{ $brand->is_active ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$brand->is_active ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-10">
                <a href="{{ route('admin.brands.index') }}" 
                   class="px-8 py-4 border border-gray-300 rounded-2xl hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-10 py-4 bg-orange-500 text-white rounded-2xl hover:bg-orange-600 transition">
                    Update Brand
                </button>
            </div>
        </form>
    </div>
</div>
@endsection