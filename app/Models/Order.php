<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [

        'customer_id',

        'order_number',
        'tracking_number',

        'first_name',
        'last_name',
        'email',
        'phone',

        'address',
        'apartment',
        'city',
        'postal_code',
        'country',

        'subtotal',
        'shipping_charges',
        'tax_charges',
        'handling_charges',
        'total_amount',

        'payment_method',

        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}