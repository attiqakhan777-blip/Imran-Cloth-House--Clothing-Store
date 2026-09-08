<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CustomerOrder;
use App\Models\CustomerOrderItem;
use App\Models\Setting;
use App\Models\Coupon;
use App\Mail\OrderPlacedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        $previousOrders = CustomerOrder::with('items')
            ->when(auth()->check(), function ($query) {
                $query->where('customer_id', auth()->id());
            }, function ($query) {
                $query->where('guest_session_id', session()->getId());
            })
            ->latest()
            ->take(5)
            ->get();

        return view('frontend.cart', compact('cart', 'previousOrders'));
    }

    public function add(Request $request, Product $product)
    {
        $validated = $request->validate([
            'size' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $size = $validated['size'] ?? null;
        $quantity = (int) $validated['quantity'];

        $this->checkStock($product, $quantity);

        $cart = session()->get('cart', []);
        $cartKey = $product->id . '_no-size';
        $price = $this->finalPrice($product);

        if (isset($cart[$cartKey])) {
            $newQuantity = (int) $cart[$cartKey]['quantity'] + $quantity;

            $this->checkStock($product, $newQuantity);

            $cart[$cartKey]['quantity'] = $newQuantity;
        } else {
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $price,
                'original_price' => $product->price,
                'discount_price' => $product->discount_price,
                'quantity' => $quantity,
                'image' => $product->images[0] ?? null,
            ];
        }

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Product added to cart.');
    }

    public function buyNow(Request $request, Product $product)
    {
        $validated = $request->validate([
            'size' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = (int) $validated['quantity'];

        $this->checkStock($product, $quantity);

        $cartKey = $product->id . '_no-size';

        session()->put('cart', [
            $cartKey => [
                'product_id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $this->finalPrice($product),
                'original_price' => $product->price,
                'discount_price' => $product->discount_price,
                'quantity' => $quantity,
                'image' => $product->images[0] ?? null,
            ],
        ]);

        return redirect()->route('checkout');
    }

    public function update(Request $request, $cartKey)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$cartKey])) {
            return back()->withErrors([
                'error' => 'Cart item not found.',
            ]);
        }

        $product = Product::findOrFail($cart[$cartKey]['product_id']);
        $quantity = (int) $request->quantity;

        $this->checkStock($product, $quantity);

        $cart[$cartKey]['quantity'] = $quantity;

        session()->put('cart', $cart);

        return back()->with('success', 'Cart updated.');
    }

    public function remove($cartKey)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Product removed from cart.');
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        $setting = Setting::first();
        $couponData = $this->resolveAppliedCoupon($cart);

        return view('frontend.checkout', compact('cart', 'setting', 'couponData'));
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => ['required', 'digits:6'],
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->withErrors(['coupon_code' => 'Your cart is empty.']);
        }

        $eligibleSubtotal = $this->eligibleSubtotalForCoupon($cart);

        if ($eligibleSubtotal <= 0) {
            return back()->withErrors([
                'coupon_code' => 'Coupon cannot be applied on sale items. Add a regular-priced item.',
            ]);
        }

        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon || !$coupon->isAvailable()) {
            return back()->withErrors([
                'coupon_code' => 'Invalid or already used coupon code.',
            ]);
        }

        $discount = min((float) $coupon->discount_amount, $eligibleSubtotal);

        session()->put('applied_coupon', [
            'code' => $coupon->code,
            'discount' => $discount,
        ]);

        return back()->with('success', 'Coupon applied successfully. Discount: Rs ' . number_format($discount));
    }

    public function removeCoupon()
    {
        session()->forget('applied_coupon');

        return back()->with('success', 'Coupon removed.');
    }

    public function placeOrder(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('cart.index')
                ->withErrors(['error' => 'Your cart is empty.']);
        }

      $validated = $request->validate([
    'email' => 'required|email',
    'first_name' => 'required|string|max:100',
    'last_name' => 'nullable|string|max:100',
    'address' => 'required|string|max:255',
    'apartment' => 'nullable|string|max:255',
    'country' => 'required|string|max:100',
    'city' => 'required|string|max:100',
    'postal_code' => 'nullable|string|max:50',
    'phone' => 'required|string|max:30',
    'shipping_method' => 'required|string|max:100',
    'payment_method' => 'required|string|max:100',
]);

        $setting = Setting::first();

        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += (float) $item['price'] * (int) $item['quantity'];
        }

        $shipping = $setting->shipping_charges ?? 0;
        $tax = $setting->tax_charges ?? 0;
        $handling = $setting->handling_charges ?? 0;

        $couponData = $this->resolveAppliedCoupon($cart);
        $couponCode = $couponData['code'] ?? null;
        $couponDiscount = (float) ($couponData['discount'] ?? 0);

        $total = max(0, $subtotal + $shipping + $tax + $handling - $couponDiscount);

        $orderNumber = 'ORD-' . date('Ymd') . '-' . rand(1000, 9999);
        $trackingNumber = 'TRK-' . date('Ymd') . '-' . rand(1000, 9999);

        $guestSessionId = auth()->check() ? null : session()->getId();

        try {
            $order = DB::transaction(function () use (
                $validated,
                $cart,
                $subtotal,
                $shipping,
                $tax,
                $handling,
                $total,
                $orderNumber,
                $trackingNumber,
                $guestSessionId,
                $couponCode,
                $couponDiscount
            ) {
                $lockedCoupon = null;

                if ($couponCode) {
                    $lockedCoupon = Coupon::where('code', $couponCode)->lockForUpdate()->first();

                    if (!$lockedCoupon || !$lockedCoupon->isAvailable()) {
                        throw ValidationException::withMessages([
                            'coupon_code' => 'Coupon is invalid or already used.',
                        ]);
                    }

                    $eligibleSubtotal = $this->eligibleSubtotalForCoupon($cart);
                    $couponDiscount = min((float) $lockedCoupon->discount_amount, $eligibleSubtotal);
                }

                $order = CustomerOrder::create([
                    'customer_id' => auth()->id(),
                    'guest_session_id' => $guestSessionId,

                    'order_number' => $orderNumber,
                    'tracking_number' => $trackingNumber,

                    'email' => $validated['email'],
                    'country' => 'Pakistan',

                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'],

                    'address' => $validated['address'],
                    'apartment' => $validated['apartment'] ?? null,

                    'city' => $validated['city'],
                    'postal_code' => $validated['postal_code'] ?? null,

                    'phone' => $validated['phone'],

                    'shipping_method' => 'Standard',

                    'shipping_charges' => $shipping,
                    'tax_charges' => $tax,
                    'handling_charges' => $handling,

                    'payment_method' => $validated['payment_method'],
                    'billing_address' => 'same',

                    'subtotal' => $subtotal,
                    'coupon_code' => $couponCode,
                    'coupon_discount' => $couponDiscount,
                    'total' => max(0, $subtotal + $shipping + $tax + $handling - $couponDiscount),

                    'status' => 'pending',
                ]);

                foreach ($cart as $item) {
                    $product = Product::findOrFail($item['product_id']);
                    $qty = (int) $item['quantity'];

                    CustomerOrderItem::create([
                        'customer_order_id' => $order->id,
                        'product_id' => $item['product_id'] ?? null,
                        'product_name' => $item['name'],
                        'product_slug' => $item['slug'] ?? null,
                        'image' => $item['image'] ?? null,
                        'price' => $item['price'],
                        'quantity' => $qty,
                        'line_total' => (float) $item['price'] * $qty,
                    ]);

                    $product->decrement('stock', $qty);
                }

                if ($lockedCoupon) {
                    $lockedCoupon->update([
                        'is_used' => true,
                        'used_at' => now(),
                    ]);
                }

                return $order;
            });
        } catch (ValidationException $e) {
            session()->forget('applied_coupon');
            return back()->withErrors($e->errors());
        }

        if (!empty($order->email)) {
            Mail::to($order->email)->send(
                new OrderPlacedMail($order->load('items.product'))
            );
        }

        session()->forget('cart');
        session()->forget('applied_coupon');

        return redirect()
            ->route('order.success', $order->id)
            ->with('success', 'Your order has been placed successfully.');
    }

    public function orderSuccess($id)
    {
        $order = CustomerOrder::with('items')->findOrFail($id);

        return view('frontend.order-success', compact('order'));
    }

    private function finalPrice(Product $product)
    {
        if (
            !empty($product->discount_price) &&
            (float) $product->discount_price > 0 &&
            (float) $product->discount_price < (float) $product->price
        ) {
            return $product->discount_price;
        }

        return $product->price;
    }

    private function isSaleCartItem(array $item): bool
    {
        $original = (float) ($item['original_price'] ?? 0);
        $discount = (float) ($item['discount_price'] ?? 0);
        $price = (float) ($item['price'] ?? 0);

        if ($discount > 0 && $original > 0 && $discount < $original) {
            return true;
        }

        if ($original > 0 && $price > 0 && $price < $original) {
            return true;
        }

        return false;
    }

    private function eligibleSubtotalForCoupon(array $cart): float
    {
        $eligible = 0;

        foreach ($cart as $item) {
            if ($this->isSaleCartItem($item)) {
                continue;
            }

            $eligible += (float) $item['price'] * (int) $item['quantity'];
        }

        return $eligible;
    }

    private function resolveAppliedCoupon(array $cart): array
    {
        $applied = session()->get('applied_coupon');

        if (empty($applied['code'])) {
            return [];
        }

        $coupon = Coupon::where('code', $applied['code'])->first();

        if (!$coupon || !$coupon->isAvailable()) {
            session()->forget('applied_coupon');
            return [];
        }

        $eligibleSubtotal = $this->eligibleSubtotalForCoupon($cart);

        if ($eligibleSubtotal <= 0) {
            session()->forget('applied_coupon');
            return [];
        }

        $discount = min((float) $coupon->discount_amount, $eligibleSubtotal);

        session()->put('applied_coupon', [
            'code' => $coupon->code,
            'discount' => $discount,
        ]);

        return [
            'code' => $coupon->code,
            'discount' => $discount,
        ];
    }

    private function checkStock(Product $product, int $quantity): void
    {
        if (!$product->is_active) {
            throw ValidationException::withMessages([
                'error' => 'This product is not available.',
            ]);
        }

        $availableStock = (int) ($product->stock ?? 0);

        if ($availableStock <= 0) {
            throw ValidationException::withMessages([
                'error' => 'This product is out of stock.',
            ]);
        }

        if ($quantity > $availableStock) {
            throw ValidationException::withMessages([
                'error' => 'Only ' . $availableStock . ' piece(s) available.',
            ]);
        }
    }
}