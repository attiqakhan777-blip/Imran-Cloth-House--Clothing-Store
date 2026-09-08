@extends('layouts.admin')

@section('title', 'Attributes')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">All Attributes</h1>
        <a href="{{ route('admin.attributes.create') }}" 
           class="bg-orange-500 text-white px-6 py-3 rounded-2xl hover:bg-orange-600">
            + Add New Attribute
        </a>
    </div>

    <div class="bg-white rounded-3xl overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left">Type</th>
                    <th class="px-6 py-4 text-left">Name</th>
                    <th class="px-6 py-4 text-left">Description</th>
                    <th class="px-6 py-4 text-center">Sort Order</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attributes as $attr)
                <tr class="border-t">
                    <td class="px-6 py-4 font-medium">{{ ucwords(str_replace('_', ' ', $attr->type)) }}</td>
                    <td class="px-6 py-4">{{ $attr->name }}</td>
                    <td class="px-6 py-4 text-gray-500">{{ $attr->description ?? '-' }}</td>
                    <td class="px-6 py-4 text-center">{{ $attr->sort_order }}</td>
                    <td class="px-6 py-4 text-center">
                        @if($attr->is_active)
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">Active</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">Inactive</span>
                        @endif
                    </td>
                <td>
    <form action="{{ route('admin.attributes.destroy', $attribute->id ?? $attr->id ?? $item->id ?? '') }}" 
          method="POST" 
          style="display: inline-block;"
          onsubmit="return confirm('Are you sure you want to delete this attribute? This action cannot be undone!')">

        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger btn-sm">
            <i class="fa fa-trash"></i> Delete
        </button>
    </form>
</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection