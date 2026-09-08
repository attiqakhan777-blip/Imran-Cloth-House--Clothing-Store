<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'discount_amount',
        'is_active',
        'is_used',
        'used_at',
    ];

    protected $casts = [
        'discount_amount' => 'decimal:2',
        'is_active' => 'boolean',
        'is_used' => 'boolean',
        'used_at' => 'datetime',
    ];

    public function isAvailable(): bool
    {
        return $this->is_active && !$this->is_used;
    }
}
