@extends('layouts.admin')

@section('title', 'Brands')

@section('content')
<div class="p-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Brands</h1>
            <a href="{{ route('admin.brands.create') }}" 
               class="px-6 py-3 bg-orange-500 text-white rounded-2xl hover:bg-orange-600 transition">
                + Add New Brand
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-2xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left">Brand Name</th>
                        <th class="px-6 py-4 text-left">Slug</th>
                        <th class="px-6 py-4 text-left">Description</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Sort Order</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($brands as $brand)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">{{ $brand->name }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $brand->slug }}</td>
                            <td class="px-6 py-4 text-gray-600 text-sm">{{ Str::limit($brand->description, 80) }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($brand->is_active)
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-medium">Active</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-medium">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">{{ $brand->sort_order }}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('admin.brands.edit', $brand) }}" 
                                   class="text-blue-600 hover:text-blue-800 mr-4">Edit</a>
                                <form action="{{ route('admin.brands.destroy', $brand) }}" 
                                      method="POST" class="inline" 
                                      onsubmit="return confirm('Delete this brand?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                No brands found. <a href="{{ route('admin.brands.create') }}" class="text-orange-500">Create one now</a>
                            </td>
                        </tr>
                    @endempty
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection