<!-- Categories Section -->
<div class="hidden lg:block mt-8">

    @php
        $path = request()->path();

        $isMenPage = str_starts_with($path, 'collection/men');
        $isWomenPage = str_starts_with($path, 'collection/women');

        $slug = request()->route('category') ?? request()->route('slug');

        $womenCategories = \App\Models\Product::where('is_active', true)
            ->where('gender', 'Women')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $menCategories = \App\Models\Product::where('is_active', true)
            ->where('gender', 'Men')
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        if ($isMenPage || $slug == 'men') {
            $title = 'Men Categories';
            $categories = $menCategories;
            $sidebarGender = 'men';
        } elseif ($isWomenPage || $slug == 'women') {
            $title = 'Women Categories';
            $categories = $womenCategories;
            $sidebarGender = 'women';
        } else {
            $title = 'Categories';
            $sidebarGender = null;

            $categories = \App\Models\Product::where('is_active', true)
                ->whereNotNull('category')
                ->where('category', '!=', '')
                ->distinct()
                ->orderBy('category')
                ->pluck('category');
        }
    @endphp

    <h3 class="font-semibold text-sm uppercase tracking-widest mb-4 border-b pb-3 text-gray-800">
        {{ $title }}
    </h3>

    <div class="space-y-2.5 text-[15px] text-gray-700">

        @forelse($categories as $cat)

            @php
                $catSlug = \Illuminate\Support\Str::slug($cat);
            @endphp

            @if($sidebarGender)
                <a href="{{ route('frontend.gender.category', ['gender' => $sidebarGender, 'category' => $catSlug]) }}"
                   class="block py-2 transition-all hover:pl-3 rounded-lg
                   {{ $slug == $catSlug ? 'text-black font-semibold' : 'text-gray-700 hover:text-black' }}">
                    {{ $cat }}
                </a>
            @else
                <a href="{{ route('frontend.collection', $catSlug) }}"
                   class="block py-2 transition-all hover:pl-3 rounded-lg
                   {{ $slug == $catSlug ? 'text-black font-semibold' : 'text-gray-700 hover:text-black' }}">
                    {{ $cat }}
                </a>
            @endif

        @empty
            <p class="text-gray-400 text-sm py-4 italic">
                No categories found.
            </p>
        @endforelse

    </div>

</div>