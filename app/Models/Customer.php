<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'address'];

    public function orders()
    {
        return $this->hasMany(Order::class);   // or CustomerOrder if you use that
    }

    /**
     * Customer's Wishlist / Favorites
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'customer_id');
    }

    /**
     * Helper: Get favorite products directly
     */
    public function favorites()
    {
        return $this->hasManyThrough(Product::class, Wishlist::class, 'customer_id', 'id', 'id', 'product_id');
    }
}