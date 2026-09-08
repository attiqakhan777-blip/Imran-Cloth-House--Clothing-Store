<?php

namespace App\Http\Controllers;

use App\Models\HomeSection;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $sections = HomeSection::where('is_active', 1)
            ->get()
            ->keyBy('section_name');

        return view('frontend.index', [
            'hero'                  => $sections['hero']->data ?? [],
            'collections'           => $sections['collections']->data ?? [],
            'shopByCategorySection' => $sections['shop_by_category'] ?? null,
            'shopByCategory'        => $sections['shop_by_category']->data ?? [],
            'sections'              => $sections,
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->get('q');

        $query = Product::query()
            ->where('is_active', true);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('category', 'LIKE', '%' . $search . '%')
                    ->orWhere('brand', 'LIKE', '%' . $search . '%')
                    ->orWhere('gender', 'LIKE', '%' . $search . '%')
                    ->orWhere('color_type', 'LIKE', '%' . $search . '%')
                    ->orWhere('color_type_custom', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('outfitType', function ($sub) use ($search) {
                        $sub->where('name', 'LIKE', '%' . $search . '%');
                    });
            });
        }

        $title = $search ? 'Search results for "' . $search . '"' : 'Search';

        $products = $query->latest()->paginate(16)->withQueryString();

        return view('frontend.collection', compact('products', 'title'));
    }

 public function collection($slug)
{
    $title = ucwords(str_replace('-', ' ', $slug));

    $query = Product::query()
        ->where('is_active', true);

    if (request()->filled('gender')) {
        $query->where('gender', request('gender'));
    }

        if ($slug === 'new-arrivals') {
            $query->where(function ($q) {
                $q->whereNull('discount_price')
                    ->orWhere('discount_price', 0)
                    ->orWhereColumn('discount_price', '>=', 'price');
            });

            $title = 'New Arrivals';

        } elseif ($slug === 'sale') {
            $query->whereNotNull('discount_price')
                ->whereColumn('discount_price', '<', 'price');

            $title = 'Sale';

            // Sale dropdown: /collection/sale?gender=Women&category=lawn
            if (request()->filled('category')) {
                $catSlug = request('category');

                $matchedCategory = Product::query()
                    ->where('is_active', true)
                    ->whereNotNull('discount_price')
                    ->whereColumn('discount_price', '<', 'price')
                    ->whereNotNull('category')
                    ->where('category', '!=', '')
                    ->when(request()->filled('gender'), fn ($q) => $q->where('gender', request('gender')))
                    ->distinct()
                    ->pluck('category')
                    ->first(fn ($name) => \Illuminate\Support\Str::slug($name) === $catSlug);

                if ($matchedCategory) {
                    $query->where('category', $matchedCategory);
                    $title = 'Sale — ' . $matchedCategory;
                }
            }

            if (request()->filled('gender') && !request()->filled('category')) {
                $title = 'Sale — ' . request('gender');
            }

        } else {
            $query->where(function ($q) use ($title) {
                $q->where('category', $title)
                    ->orWhere('gender', $title)
                    ->orWhere('brand', $title)
                    ->orWhereHas('outfitType', function ($sub) use ($title) {
                        $sub->where('name', $title);
                    });
            });
        }

        $sort = request('sort', 'newest');

        if ($sort === 'price-low') {
            $query->orderByRaw('COALESCE(NULLIF(discount_price, 0), price) ASC');
        } elseif ($sort === 'price-high') {
            $query->orderByRaw('COALESCE(NULLIF(discount_price, 0), price) DESC');
        } else {
            $query->latest();
        }

        $products = $query->paginate(16)->withQueryString();

        return view('frontend.collection', compact('products', 'title'));
    }

    public function lawn()
    {
        return view('frontend.lawn');
    }

    public function unstitched()
    {
        return view('frontend.unstitched');
    }

    public function wedding()
    {
        return view('frontend.wedding');
    }

    public function pret()
    {
        return view('frontend.pret');
    }

  public function brands()
{
    $womenBrands = Product::where('is_active', true)
        ->where('gender', 'women')
        ->whereNotNull('brand')
        ->where('brand', '!=', '')
        ->select('brand')
        ->distinct()
        ->orderBy('brand', 'asc')
        ->pluck('brand');

    $menBrands = Product::where('is_active', true)
        ->where('gender', 'men')
        ->whereNotNull('brand')
        ->where('brand', '!=', '')
        ->select('brand')
        ->distinct()
        ->orderBy('brand', 'asc')
        ->pluck('brand');

    return view('frontend.brands', compact('womenBrands', 'menBrands'));
}

    public function productDetail($slug)
    {
        $product = Product::where('slug', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();

        $isInWishlist = false;

        if (auth()->check()) {
            $isInWishlist = \App\Models\Favorite::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->exists();
        }

        $relatedProducts = Product::where('id', '!=', $product->id)
            ->where('is_active', true)
            ->where(function ($query) use ($product) {
                $query->where('category', $product->category)
                    ->orWhere('gender', $product->gender);
            })
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.product-detail', compact('product', 'relatedProducts', 'isInWishlist'));
    }
    public function fragrances()
{
    $products = \App\Models\Product::where('is_active', 1)
        ->where('category', 'Fragrances')
        ->latest()
        ->paginate(16);

    return view('frontend.fragrances', compact('products'));
}
public function genderCategory($gender, $category)
{
    $genderName = strtolower($gender) == 'men' ? 'Men' : 'Women';

    $categoryName = ucwords(str_replace('-', ' ', $category));

    $products = \App\Models\Product::where('is_active', true)
        ->where('gender', $genderName)
        ->whereRaw('LOWER(REPLACE(category, " ", "-")) = ?', [strtolower($category)])
        ->latest()
        ->paginate(16);

    return view('frontend.collection', [
        'products' => $products,
        'slug' => $category,
        'pageTitle' => $genderName . ' ' . $categoryName,
    ]);
}
}