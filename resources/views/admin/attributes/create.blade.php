@extends('layouts.admin')

@section('title', 'Create Attribute')

@section('content')
<div class="p-6">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Create New Attribute</h1>
            <a href="{{ route('admin.attributes.index') }}" class="text-gray-500 hover:text-black">← Back</a>
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

        <form action="{{ route('admin.attributes.store') }}" method="POST" class="bg-white rounded-3xl p-8">
            @csrf

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Attribute Type <span class="text-red-500">*</span></label>
                    <select name="type" class="w-full border border-gray-300 rounded-2xl px-5 py-4" required>
                        @foreach($types as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="w-full border border-gray-300 rounded-2xl px-5 py-4" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-2xl px-5 py-4"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Sort Order</label>
                    <input type="number" name="sort_order" value="0" class="w-full border border-gray-300 rounded-2xl px-5 py-4">
                </div>
            </div>

            <div class="flex justify-end gap-4 mt-10">
                <a href="{{ route('admin.attributes.index') }}" class="px-8 py-4 border border-gray-300 rounded-2xl hover:bg-gray-50">Cancel</a>
                <button type="submit" class="px-10 py-4 bg-orange-500 text-white rounded-2xl hover:bg-orange-600">Create Attribute</button>
            </div>
        </form>
    </div>
</div>
@endsection