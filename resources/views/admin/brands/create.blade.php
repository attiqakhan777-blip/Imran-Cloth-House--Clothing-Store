@extends('layouts.admin')

@section('title', 'Create Brand')

@section('content')
<div class="p-6">
    <div class="max-w-2xl mx-auto">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Create New Brand</h1>
            <a href="{{ route('admin.brands.index') }}" class="text-gray-500 hover:text-black">← Back</a>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-2xl mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.brands.store') }}" method="POST" class="bg-white rounded-3xl p-8">
            @csrf

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Brand Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" 
                           class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:outline-none focus:border-orange-500" 
                           placeholder="e.g. Sapphire" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Description</label>
                    <textarea name="description" rows="4"
                              class="w-full border border-gray-300 rounded-2xl px-5 py-4 focus:outline-none focus:border-orange-500"
                              placeholder="Short description about this brand..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">Sort Order</label>
                        <input type="number" name="sort_order" value="0"
                               class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Status</label>
                        <select name="is_active" class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-10">
                <a href="{{ route('admin.brands.index') }}" 
                   class="px-8 py-4 border border-gray-300 rounded-2xl hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-10 py-4 bg-orange-500 text-white rounded-2xl hover:bg-orange-600 transition">
                    Create Brand
                </button>
            </div>
        </form>
    </div>
</div>
@endsection