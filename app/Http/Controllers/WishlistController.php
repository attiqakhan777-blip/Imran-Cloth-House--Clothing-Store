<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;     // ← This line was missing
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function toggle(Request $request)
    {
        $user = auth()->user();
        $productId = $request->input('product_id');

        if (!$productId) {
            return response()->json([
                'success' => false,
                'message' => 'Product ID is required'
            ], 400);
        }

        $product = Product::findOrFail($productId);

        $favorite = Favorite::where('user_id', $user->id)
                            ->where('product_id', $productId)
                            ->first();

        if ($favorite) {
            $favorite->delete();
            $message = 'Removed from wishlist';
        } else {
            Favorite::create([
                'user_id'    => $user->id,
                'product_id' => $productId,
            ]);
            $message = 'Added to wishlist ❤️';
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    public function index()
    {
        $favorites = auth()->user()
                           ->favorites()
                           ->with('product')
                           ->latest()
                           ->get();

        return view('frontend.favorites', compact('favorites'));
    }
}