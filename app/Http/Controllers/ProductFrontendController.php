<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductFrontendController extends Controller
{
    /**
     * Women Collection
     */
    public function women()
    {
        $products = Product::where('gender', 'Women')
                            ->where('is_active', true)   // or 'status' if you use that
                            ->latest()
                            ->paginate(16);

        return view('women', compact('products'));
    }

    /**
     * Men Collection
     */
    public function men()
    {
        $products = Product::where('gender', 'Men')
                            ->where('is_active', true)
                            ->latest()
                            ->paginate(16);

        return view('men', compact('products'));
    }

    /**
     * Kids Collection
     */
    public function kids()
    {
        $products = Product::where('gender', 'Kids')
                            ->where('is_active', true)
                            ->latest()
                            ->paginate(16);

        return view('kids', compact('products'));
    }

    /**
     * General / Filter API (if you want to use JS fetch later)
     */
    public function index(Request $request)
    {
        $query = Product::query()->where('is_active', true);

        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'price-low'  => $query->orderBy('price', 'asc'),
            'price-high' => $query->orderBy('price', 'desc'),
            default      => $query->latest(),
        };

        $products = $query->paginate(16);

        // Return JSON only if requested via AJAX
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($products);
        }

        // Otherwise return view (fallback)
        return view('products.index', compact('products'));
    }
    
}