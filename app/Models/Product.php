<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('nav.menu'));
        static::deleted(fn () => Cache::forget('nav.menu'));
    }

    protected $fillable = [
        'name',
        'slug',
        'product_id',
        'price',
        'discount_price',
        'description',

        'brand',
        'category',
        'gender',
        'stock',

        'outfit_type_id',
        'style_id',

        'color_type',
        'color_type_custom',

        'images',

        'is_active',
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function outfitType()
    {
        return $this->belongsTo(Attribute::class, 'outfit_type_id');
    }

    public function style()
    {
        return $this->belongsTo(Attribute::class, 'style_id');
    }

    public function getBrandNameAttribute()
    {
        return $this->brand ?? 'N/A';
    }

    public function getCategoryNameAttribute()
    {
        return $this->category ?? 'N/A';
    }

    public function getOutfitTypeNameAttribute()
    {
        return $this->outfitType?->name ?? 'N/A';
    }

    public function getStyleNameAttribute()
    {
        return $this->style?->name ?? 'N/A';
    }

    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    public function getMainImageAttribute()
    {
        if (is_array($this->images) && count($this->images) > 0) {
            return $this->images[0];
        }

        return null;
    }

    public function getTotalStockAttribute()
    {
        return (int) ($this->stock ?? 0);
    }

    public function reduceStock(int $quantity = 1): void
    {
        if ((int) $this->stock < $quantity) {
            throw new \Exception("Not enough stock for product: {$this->name}");
        }

        $this->stock = (int) $this->stock - $quantity;
        $this->save();
    }
}