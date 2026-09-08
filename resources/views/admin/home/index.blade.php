@extends('layouts.admin')

@section('title', 'Manage Homepage')
@section('page_title', 'Manage Homepage')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <div class="bg-white rounded-3xl p-8 shadow-sm">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold">Manage Homepage</h1>
                <p class="text-gray-500 mt-2">
                    Create homepage sections like Top Curations, Popular Demand, New Arrivals, and add images inside them.
                </p>
            </div>

            <a href="{{ url('/') }}" target="_blank"
               class="px-6 py-3 rounded-2xl border border-gray-300 text-sm font-semibold hover:bg-black hover:text-white transition">
                View Homepage
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-2xl">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-2xl">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Create New Section --}}
        <div class="mb-10 bg-gray-50 border border-gray-200 rounded-3xl p-6">
            <h2 class="text-2xl font-bold mb-4">Create New Homepage Section</h2>

            <form method="POST" action="{{ route('admin.home.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">
                        Section Name
                    </label>
                    <input type="text"
                           name="section_name"
                           placeholder="top_curations"
                           class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                           required>
                    <p class="text-xs text-gray-400 mt-1">
                        Example: top_curations
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">
                        Display Heading
                    </label>
                    <input type="text"
                           name="title"
                           placeholder="TOP CURATIONS"
                           class="w-full border border-gray-300 rounded-2xl px-4 py-3"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-600 mb-2">
                        Subtitle Optional
                    </label>
                    <input type="text"
                           name="subtitle"
                           placeholder="Latest premium picks"
                           class="w-full border border-gray-300 rounded-2xl px-4 py-3">
                </div>

                <button type="submit"
                        class="bg-orange-600 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-orange-700">
                    + Create Section
                </button>
            </form>
        </div>

        {{-- Existing Sections --}}
        @if(empty($sections) || $sections->isEmpty())
            <div class="text-center py-16 bg-gray-50 rounded-3xl">
                <h2 class="text-xl font-semibold text-gray-700">No homepage sections found</h2>
                <p class="text-gray-500 mt-2">
                    Create your first section above.
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                @foreach($sections as $section)
                    <div class="border border-gray-200 rounded-3xl p-8 hover:shadow-xl transition-all group bg-white">

                        <div class="flex justify-between items-start mb-6 gap-4">
                            <div>
                                <h3 class="text-2xl font-semibold capitalize">
                                    {{ str_replace('_', ' ', $section->section_name) }}
                                </h3>

                                <p class="text-gray-500 mt-1">
                                    {{ $section->title ?? 'No title set' }}
                                </p>

                                @if(!empty($section->subtitle))
                                    <p class="text-gray-400 text-sm mt-1">
                                        {{ $section->subtitle }}
                                    </p>
                                @endif
                            </div>

                            <span class="px-4 py-1.5 text-sm font-medium rounded-2xl whitespace-nowrap
                                {{ $section->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $section->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div class="mb-6">
                            <p class="text-sm text-gray-500">
                                Items:
                                <span class="font-semibold text-gray-800">
                                    {{ is_array($section->data) ? count($section->data) : 0 }}
                                </span>
                            </p>
                        </div>

                        <div class="flex gap-3">
                            <a href="{{ route('admin.home.edit', $section->section_name) }}"
                               class="flex-1 text-center bg-black text-white py-4 rounded-2xl hover:bg-gray-800 transition font-semibold">
                                ✏️ Edit
                            </a>

                            @if(!in_array($section->section_name, ['hero', 'collections']))
                                <form method="POST"
                                      action="{{ route('admin.home.destroy', $section->section_name) }}"
                                      onsubmit="return confirm('Delete this homepage section?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="px-5 py-4 rounded-2xl bg-red-600 text-white hover:bg-red-700">
                                        🗑
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                @endforeach

            </div>
        @endif

    </div>

</div>
@endsection