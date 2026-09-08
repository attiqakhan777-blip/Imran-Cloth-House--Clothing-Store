<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductFrontendController;

// Fetch products for frontend (Women, Men, etc.)
Route::get('/products', [ProductFrontendController::class, 'index']);