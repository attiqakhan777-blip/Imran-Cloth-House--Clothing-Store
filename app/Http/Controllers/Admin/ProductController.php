<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('product_id', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(15);

        return view('admin.products.list', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'product_id'  => 'nullable|string|unique:products,product_id|max:50',
            'category'    => 'required|string',
            'images.*'    => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $productId = $request->product_id;

        if (empty($productId)) {
            do {
                $date = now()->format('Ymd');
                $random = str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
                $productId = "LIB-{$date}-{$random}";
            } while (Product::where('product_id', $productId)->exists());
        }

        $brandName = $request->brand;

        if ($request->brand === 'custom' && $request->filled('brand_custom')) {
            $brandName = trim($request->brand_custom);

            Brand::firstOrCreate(
                ['name' => $brandName],
                [
                    'slug' => Str::slug($brandName),
                    'is_active' => true,
                ]
            );
        }

        $colorType = $request->input('color_type');

        if ($colorType === 'Custom') {
            $colorType = $request->input('color_type_custom');
        }

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products'), $filename);
                $imagePaths[] = 'uploads/products/' . $filename;
            }
        }

        Product::create([
            'name'              => $request->name,
            'slug'              => $slug,
            'description'       => $request->description,
            'price'             => $request->price,
            'discount_price'    => $request->discount_price,
            'product_id'        => $productId,
            'brand'             => $brandName,
            'category'          => $request->category,
            'gender'            => $request->gender,

            'outfit_type_id'    => $request->outfit_type_id,
            'style_id'          => $request->style_id,

            'color_type'        => $colorType,
            'color_type_custom' => $request->color_type_custom,

            'stock'             => $request->stock,
            'images'            => $imagePaths,
            'is_active'         => true,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', '✅ Product created successfully!');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'product_id'  => 'required|string|unique:products,product_id,' . $product->id,
            'images.*'    => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $brandName = $request->brand;

        if ($request->brand === 'custom' && $request->filled('brand_custom')) {
            $brandName = trim($request->brand_custom);

            Brand::firstOrCreate(
                ['name' => $brandName],
                ['slug' => Str::slug($brandName)]
            );
        }

        $colorType = $request->input('color_type');

        if ($colorType === 'Custom') {
            $colorType = $request->input('color_type_custom');
        }

        $slug = $product->slug;

        if ($product->name !== $request->name) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $count = 1;

            while (
                Product::where('slug', $slug)
                    ->where('id', '!=', $product->id)
                    ->exists()
            ) {
                $slug = $originalSlug . '-' . $count++;
            }
        }

        $imagePaths = $product->images ?? [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products'), $filename);
                $imagePaths[] = 'uploads/products/' . $filename;
            }
        }

        $product->update([
            'name'              => $request->name,
            'slug'              => $slug,
            'description'       => $request->description,
            'price'             => $request->price,
            'discount_price'    => $request->discount_price,
            'product_id'        => $request->product_id,
            'brand'             => $brandName,
            'category'          => $request->category,
            'gender'            => $request->gender,

            'outfit_type_id'    => $request->outfit_type_id,
            'style_id'          => $request->style_id,

            'color_type'        => $colorType,
            'color_type_custom' => $request->color_type_custom,

            'stock'             => $request->stock,
            'images'            => $imagePaths,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', '✅ Product updated successfully!');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array|min:1',
        ]);

        $products = Product::whereIn('id', $request->ids)->get();

        foreach ($products as $product) {
            if (!empty($product->images)) {
                foreach ((array) $product->images as $imagePath) {
                    $fullPath = public_path($imagePath);

                    if (file_exists($fullPath)) {
                        @unlink($fullPath);
                    }
                }
            }

            $product->delete();
        }

        return redirect()->route('admin.products.index')
            ->with('success', '✅ Selected products deleted successfully!');
    }

    public function bulkDiscount(Request $request)
    {
        $request->validate([
            'product_ids'    => 'required|array|min:1',
            'discount_type'  => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
        ]);

        $products = Product::whereIn('id', $request->product_ids)->get();

        foreach ($products as $product) {
            if ($request->discount_type === 'percentage') {
                $newPrice = $product->price * (1 - ($request->discount_value / 100));
            } else {
                $newPrice = $product->price - $request->discount_value;
            }

            $newPrice = max(0, min($newPrice, $product->price));

            $product->update([
                'discount_price' => round($newPrice, 2),
            ]);
        }

        return redirect()->back()
            ->with('success', '✅ Discount applied successfully!');
    }
}