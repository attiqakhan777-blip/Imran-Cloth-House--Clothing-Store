<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->get();

        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'digits:6', 'unique:coupons,code'],
            'discount_amount' => ['required', 'numeric', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Coupon::create([
            'code' => $validated['code'],
            'discount_amount' => $validated['discount_amount'],
            'is_active' => $request->boolean('is_active', true),
            'is_used' => false,
        ]);

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon created successfully!');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code' => ['required', 'digits:6', 'unique:coupons,code,' . $coupon->id],
            'discount_amount' => ['required', 'numeric', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $coupon->update([
            'code' => $validated['code'],
            'discount_amount' => $validated['discount_amount'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon updated successfully!');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()
            ->route('admin.coupons.index')
            ->with('success', 'Coupon deleted successfully!');
    }
}
