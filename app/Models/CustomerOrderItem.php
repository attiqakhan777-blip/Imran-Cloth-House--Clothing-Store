<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerOrder;
use App\Models\Product;

class CustomerOrderItem extends Model
{
    protected $fillable = [
        'customer_order_id',
        'product_id',
        'product_code',
        'product_name',
        'product_slug',
        'size',
        'image',
        'price',
        'quantity',
        'line_total',
    ];

    // Order relation
    public function order()
    {
        return $this->belongsTo(CustomerOrder::class, 'customer_order_id');
    }

    // Product relation
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}