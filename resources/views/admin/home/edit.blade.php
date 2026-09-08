@extends('layouts.admin')

@section('title', 'Edit ' . ucfirst(str_replace('_', ' ', $section->section_name ?? 'Section')))
@section('page_title', 'Edit ' . ucfirst(str_replace('_', ' ', $section->section_name ?? 'Section')))

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <div class="bg-white rounded-3xl p-8 shadow-sm">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold">
                    Edit {{ ucfirst(str_replace('_', ' ', $section->section_name ?? '')) }} Section
                </h1>
                <p class="text-gray-500 mt-2">
                    Add images, titles, subtitles, and links for this homepage section.
                </p>
            </div>

            <a href="{{ route('admin.home.manage') }}" class="text-gray-500 hover:text-black transition-colors">
                ← Back
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-2xl">
                {{ session('success') }}
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

        <form method="POST" action="{{ route('admin.home.update', $section->section_name) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Basic Info --}}
            <div class="mb-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Display Title</label>
                    <input type="text" name="title" value="{{ old('title', $section->title ?? '') }}"
                           class="w-full border border-gray-200 rounded-2xl px-5 py-4 text-lg focus:ring-2 focus:ring-orange-500 outline-none">
                </div>
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Display Subtitle (Optional)</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle', $section->subtitle ?? '') }}"
                           class="w-full border border-gray-200 rounded-2xl px-5 py-4 text-lg focus:ring-2 focus:ring-orange-500 outline-none">
                </div>
            </div>

            <div class="mb-10">
                <label class="inline-flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300"
                           {{ old('is_active', $section->is_active ?? false) ? 'checked' : '' }}>
                    <span class="font-semibold text-gray-700">Show this section on homepage</span>
                </label>
            </div>

            <hr class="mb-10 border-gray-100">

            {{-- ==================== SECTION SPECIFIC ==================== --}}
            @if($section->section_name === 'hero')
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold">Hero Slides</h2>
                    <button type="button" onclick="addItem('slides-container', 'slide')"
                            class="bg-orange-600 text-white px-6 py-3 rounded-2xl hover:bg-orange-700 transition-colors">
                        + Add New Slide
                    </button>
                </div>
                <div id="slides-container" class="space-y-6">
                    @foreach($section->data ?? [] as $i => $slide)
                        <div class="border rounded-3xl p-6 bg-gray-50 item-wrapper relative group">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-1">
                                    @if(!empty($slide['image']))
                                      <img src="{{ asset($slide['image']) }}" class="w-full h-40 object-cover rounded-2xl mb-3">
                                    @else
                                        <div class="w-full h-40 bg-gray-200 rounded-2xl mb-3 flex items-center justify-center text-gray-400">No Image</div>
                                    @endif
                                    <input type="file" name="slides[{{ $i }}][new_image]" class="w-full text-sm">
                                    <input type="hidden" name="slides[{{ $i }}][image]" value="{{ $slide['image'] ?? '' }}">
                                </div>
                                <div class="md:col-span-2 space-y-3">
                                    <input type="text" name="slides[{{ $i }}][title]" value="{{ $slide['title'] ?? '' }}" placeholder="Slide Title" class="w-full border rounded-xl px-4 py-3">
                                    <input type="text" name="slides[{{ $i }}][subtitle]" value="{{ $slide['subtitle'] ?? '' }}" placeholder="Slide Subtitle" class="w-full border rounded-xl px-4 py-3">
                                    <input type="text" name="slides[{{ $i }}][link]" value="{{ $slide['link'] ?? '#' }}" placeholder="Link URL" class="w-full border rounded-xl px-4 py-3">
                                </div>
                            </div>
                            <button type="button" class="absolute top-4 right-4 text-red-500 hover:text-red-700 remove-item">🗑 Remove</button>
                        </div>
                    @endforeach
                </div>

            @elseif($section->section_name === 'collections')
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold">Circle Collections</h2>
                    <button type="button" onclick="addItem('collections-container', 'collection')"
                            class="bg-orange-600 text-white px-6 py-3 rounded-2xl hover:bg-orange-700 transition-colors">
                        + Add New Collection
                    </button>
                </div>
                <div id="collections-container" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($section->data ?? [] as $i => $item)
                        <div class="border rounded-3xl p-6 bg-gray-50 item-wrapper relative group">
                            <div class="flex gap-4">
                                <div class="w-24 flex-shrink-0">
                                    @if(!empty($item['image']))
                                       <img src="{{ asset($item['image']) }}" class="w-24 h-24 object-cover rounded-full border-2 border-white shadow-sm mb-3">
                                    @else
                                        <div class="w-24 h-24 bg-gray-200 rounded-full mb-3 flex items-center justify-center text-gray-400 text-xs">No Image</div>
                                    @endif
                                    <input type="file" name="collections[{{ $i }}][new_image]" class="text-xs w-full">
                                    <input type="hidden" name="collections[{{ $i }}][image]" value="{{ $item['image'] ?? '' }}">
                                </div>
                                <div class="flex-1 space-y-3">
                                    <input type="text" name="collections[{{ $i }}][title]" value="{{ $item['title'] ?? '' }}" placeholder="Collection Title" class="w-full border border-gray-300 rounded-xl px-4 py-3">
                                    <input type="text" name="collections[{{ $i }}][link]" value="{{ $item['link'] ?? '#' }}" placeholder="Link URL" class="w-full border border-gray-300 rounded-xl px-4 py-3">
                                    <label class="flex items-center gap-2 text-sm cursor-pointer">
                                        <input type="checkbox" name="collections[{{ $i }}][sale]" value="1" {{ !empty($item['sale']) ? 'checked' : '' }}>
                                        <span class="text-gray-700">Show SALE Tag</span>
                                    </label>
                                </div>
                            </div>
                            <button type="button" class="absolute top-4 right-4 text-red-500 hover:text-red-700 remove-item">🗑</button>
                        </div>
                    @endforeach
                </div>

            @else
                {{-- NEW ARRIVALS + OTHER SECTIONS --}}
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold uppercase tracking-tight">
                        Items in {{ ucfirst(str_replace('_', ' ', $section->section_name)) }}
                    </h2>
                    <button type="button" onclick="addItem('items-container', 'item')"
                            class="bg-orange-600 text-white px-6 py-3 rounded-2xl hover:bg-orange-700 transition-colors">
                        + Add New Item
                    </button>
                </div>
                <div id="items-container" class="space-y-6">
                    @foreach($section->data ?? [] as $i => $item)
                        <div class="border rounded-3xl p-6 bg-gray-50 item-wrapper relative group">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-center">
                                <div class="md:col-span-1">
@if(!empty($item['image']))
<img
src="{{ asset($item['image']) }}"
class="h-40 w-full object-cover rounded-2xl mb-3"
>
@else
<div class="h-40 w-full bg-gray-200 rounded-2xl mb-3 flex items-center justify-center text-gray-400">
No Image
</div>
@endif
                                    <input type="file" name="items[{{ $i }}][new_image]" class="text-xs w-full">
                                    <input type="hidden" name="items[{{ $i }}][image]" value="{{ $item['image'] ?? '' }}">
                                </div>
                                <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <input type="text" name="items[{{ $i }}][title]" value="{{ $item['title'] ?? '' }}" placeholder="Title" class="w-full border rounded-xl px-4 py-3">
                                    <input type="text" name="items[{{ $i }}][subtitle]" value="{{ $item['subtitle'] ?? '' }}" placeholder="Subtitle" class="w-full border rounded-xl px-4 py-3">
                                    <input type="text" name="items[{{ $i }}][link]" value="{{ $item['link'] ?? '#' }}" placeholder="Link URL" class="w-full border rounded-xl px-4 py-3 md:col-span-2">
                                </div>
                            </div>
                            <button type="button" class="absolute top-4 right-4 text-red-500 hover:text-red-700 remove-item">🗑 Remove</button>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Save Button --}}
            <div class="mt-12 pt-8 border-t border-gray-100">
                <button type="submit" class="w-full md:w-auto bg-black text-white px-12 py-5 rounded-2xl font-bold text-lg hover:bg-gray-800 transition-all flex items-center justify-center gap-2">
                    💾 Save All Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function addItem(containerId, type) {
    const container = document.getElementById(containerId);
    const index = container.children.length;

    let html = '';

    if (type === 'slide') {  // For Hero
        html = `
            <div class="border rounded-3xl p-6 bg-gray-50 item-wrapper relative group">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <div class="w-full h-40 bg-gray-200 rounded-2xl mb-3 flex items-center justify-center text-gray-400">New Slide Image</div>
                        <input type="file" name="slides[${index}][new_image]" class="w-full text-sm">
                        <input type="hidden" name="slides[${index}][image]" value="">
                    </div>
                    <div class="md:col-span-2 space-y-3">
                        <input type="text" name="slides[${index}][title]" placeholder="Slide Title" class="w-full border rounded-xl px-4 py-3">
                        <input type="text" name="slides[${index}][subtitle]" placeholder="Slide Subtitle" class="w-full border rounded-xl px-4 py-3">
                        <input type="text" name="slides[${index}][link]" value="#" placeholder="Link URL (e.g. /collection/pret)" class="w-full border rounded-xl px-4 py-3">
                    </div>
                </div>
                <button type="button" class="absolute top-4 right-4 text-red-500 hover:text-red-700 remove-item">🗑 Remove</button>
            </div>`;
    } 
    else if (type === 'collection') {  // For Collections
        html = `
            <div class="border rounded-3xl p-6 bg-gray-50 item-wrapper relative group">
                <div class="flex gap-4">
                    <div class="w-24 flex-shrink-0">
                        <div class="w-24 h-24 bg-gray-200 rounded-full mb-3 flex items-center justify-center text-gray-400 text-xs">New Image</div>
                        <input type="file" name="collections[${index}][new_image]" class="text-xs w-full">
                        <input type="hidden" name="collections[${index}][image]" value="">
                    </div>
                    <div class="flex-1 space-y-3">
                        <input type="text" name="collections[${index}][title]" placeholder="Collection Title" class="w-full border border-gray-300 rounded-xl px-4 py-3">
                        <input type="text" name="collections[${index}][link]" value="#" placeholder="Link URL" class="w-full border border-gray-300 rounded-xl px-4 py-3">
                        <label class="flex items-center gap-2 text-sm cursor-pointer">
                            <input type="checkbox" name="collections[${index}][sale]" value="1">
                            <span class="text-gray-700">Show SALE Tag</span>
                        </label>
                    </div>
                </div>
                <button type="button" class="absolute top-4 right-4 text-red-500 hover:text-red-700 remove-item">🗑 Remove</button>
            </div>`;
    } 
    else {  // For other sections (New Arrivals etc.)
        html = `
            <div class="border rounded-3xl p-6 bg-gray-50 item-wrapper relative group">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-center">
                    <div class="md:col-span-1">
                        <div class="h-40 w-full bg-gray-200 rounded-2xl mb-3 flex items-center justify-center text-gray-400">New Image</div>
                        <input type="file" name="items[${index}][new_image]" class="text-xs w-full">
                        <input type="hidden" name="items[${index}][image]" value="">
                    </div>
                    <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="items[${index}][title]" placeholder="Title" class="w-full border rounded-xl px-4 py-3">
                        <input type="text" name="items[${index}][subtitle]" placeholder="Subtitle" class="w-full border rounded-xl px-4 py-3">
                        <input type="text" name="items[${index}][link]" value="#" placeholder="Link URL" class="w-full border rounded-xl px-4 py-3 md:col-span-2">
                    </div>
                </div>
                <button type="button" class="absolute top-4 right-4 text-red-500 hover:text-red-700 remove-item">🗑 Remove</button>
            </div>`;
    }

    container.insertAdjacentHTML('beforeend', html);
}

// Remove item functionality
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-item')) {
        if (confirm('Remove this item?')) {
            e.target.closest('.item-wrapper').remove();
        }
    }
});
</script>
@endsection