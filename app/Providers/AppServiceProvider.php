<?php

namespace App\Providers;

use App\Models\Product;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $view->with([
                'womenCategories'     => self::cats('Women'),
                'menCategories'       => self::cats('Men'),
                'kidsCategories'      => self::cats('Kids'),
                'saleWomenCategories' => self::saleCats('Women'),
                'saleMenCategories'   => self::saleCats('Men'),
            ]);
        });
    }

    private static function cats(string $gender)
    {
        return Product::query()
            ->where('is_active', true)
            ->where('gender', $gender)
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->filter(fn ($c) => is_string($c) && trim($c) !== '')
            ->unique()
            ->values();
    }

    private static function saleCats(?string $gender = null)
    {
        $query = Product::query()
            ->where('is_active', true)
            ->whereNotNull('discount_price')
            ->whereColumn('discount_price', '<', 'price')
            ->whereNotNull('category')
            ->where('category', '!=', '');

        if ($gender) {
            $query->where('gender', $gender);
        }

        return $query
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->filter(fn ($c) => is_string($c) && trim($c) !== '')
            ->unique()
            ->values();
    }
}
