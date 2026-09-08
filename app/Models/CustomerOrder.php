<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerOrderItem;

class CustomerOrder extends Model
{
    // ✅ THIS MUST BE ORDERS TABLE
    protected $table = 'customer_orders';

    protected $fillable = [
        'customer_id',
        'guest_session_id',
        'order_number',
        'tracking_number',
        'email',
        'country',
        'first_name',
        'last_name',
        'address',
        'apartment',
        'city',
        'postal_code',
        'phone',
        'shipping_method',
        'shipping_charges',
        'tax_charges',
        'handling_charges',
        'payment_method',
        'billing_address',
        'subtotal',
        'coupon_code',
        'coupon_discount',
        'total',
        'status',
    ];

    // 🔗 Relationship: Order has many items
    public function items()
    {
        return $this->hasMany(CustomerOrderItem::class, 'customer_order_id');
    }
}