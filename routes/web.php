<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| FRONTEND CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\WishlistController;

/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CouponController;

/*
|--------------------------------------------------------------------------
| FRONTEND ROUTES
|--------------------------------------------------------------------------
*/

// ====================== HOME ======================
Route::get('/', [FrontendController::class, 'index'])->name('home');

// ====================== BRANDS & COLLECTIONS ======================
Route::get('/pages/brands', [FrontendController::class, 'brands'])
    ->name('frontend.brands');

Route::get('/collection/{slug}', [FrontendController::class, 'collection'])
    ->name('frontend.collection');
    Route::get('/collection/{gender}/{category}', [FrontendController::class, 'genderCategory'])
    ->name('frontend.gender.category');

// ====================== CATEGORIES ======================
Route::get('/lawn', [FrontendController::class, 'lawn'])
    ->name('frontend.lawn');

Route::get('/unstitched', [FrontendController::class, 'unstitched'])
    ->name('frontend.unstitched');

Route::get('/wedding', [FrontendController::class, 'wedding'])
    ->name('frontend.wedding');

Route::get('/pret', [FrontendController::class, 'pret'])
    ->name('frontend.pret');

// ====================== PRODUCT & SEARCH ======================
Route::get('/product/{slug}', [FrontendController::class, 'productDetail'])
    ->name('product.detail');

Route::get('/search', [FrontendController::class, 'search'])
    ->name('frontend.search');

// ====================== CUSTOMER AUTH ======================
Route::get('/account/login', [CustomerAuthController::class, 'showLogin'])
    ->name('customer.login');

Route::post('/account/login', [CustomerAuthController::class, 'login'])
    ->name('customer.login.submit');

Route::get('/account/register', [CustomerAuthController::class, 'showRegister'])
    ->name('customer.register');

Route::post('/account/register', [CustomerAuthController::class, 'register'])
    ->name('customer.register.submit');

Route::post('/account/logout', [CustomerAuthController::class, 'logout'])
    ->name('customer.logout');

// ====================== OTP FORGOT PASSWORD FLOW ======================
Route::get('/account/forgot-password', [CustomerAuthController::class, 'showForgotPassword'])
    ->name('customer.password.request');

Route::post('/account/forgot-password', [CustomerAuthController::class, 'forgotPassword'])
    ->name('customer.password.email');

Route::get('/verify-otp', [CustomerAuthController::class, 'showVerifyOtp'])
    ->name('verify.otp');

Route::post('/verify-otp', [CustomerAuthController::class, 'verifyOtp'])
    ->name('verify.otp.submit');

Route::get('/reset-password', [CustomerAuthController::class, 'showResetPassword'])
    ->name('reset.password');

Route::post('/reset-password', [CustomerAuthController::class, 'resetPassword'])
    ->name('reset.password.submit');

// ====================== CUSTOMER PROTECTED ROUTES ======================
Route::middleware('auth')->group(function () {

    Route::get('/account', [CustomerAuthController::class, 'account'])
        ->name('customer.account');
Route::get('/account/orders', [CustomerAuthController::class, 'orders'])->name('customer.orders');
    // Wishlist
Route::post('/wishlist/toggle', [App\Http\Controllers\WishlistController::class, 'toggle'])
     ->name('wishlist.toggle');

Route::get('/account/favorites', [App\Http\Controllers\WishlistController::class, 'index'])
     ->name('customer.favorites');
});

// ====================== CART ======================
Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::post('/cart/add/{product}', [CartController::class, 'add'])
    ->name('cart.add');

Route::post('/cart/update/{cartKey}', [CartController::class, 'update'])
    ->name('cart.update');

Route::post('/cart/remove/{cartKey}', [CartController::class, 'remove'])
    ->name('cart.remove');

Route::post('/buy-now/{product}', [CartController::class, 'buyNow'])
    ->name('cart.buyNow');

// ====================== CHECKOUT ======================
Route::get('/checkout', [CartController::class, 'checkout'])
    ->name('checkout');

Route::post('/checkout/apply-coupon', [CartController::class, 'applyCoupon'])
    ->name('checkout.applyCoupon');

Route::post('/checkout/remove-coupon', [CartController::class, 'removeCoupon'])
    ->name('checkout.removeCoupon');

Route::post('/checkout/place-order', [CartController::class, 'placeOrder'])
    ->name('checkout.placeOrder');

Route::get('/order-success/{id}', [CartController::class, 'orderSuccess'])
    ->name('order.success');
use App\Http\Controllers\Frontend\PageController;

Route::get('/about-us', [PageController::class, 'about'])->name('about');
Route::get('/contact-us', [PageController::class, 'contact'])->name('contact');
Route::get('/store-locator', [PageController::class, 'storeLocator'])->name('store.locator');
Route::get('/bank-details', [PageController::class, 'bankDetails'])->name('bank.details');
Route::get('/exchange-refund-policy',[PageController::class,'exchangeRefund'])->name('exchange.refund');

Route::get('/terms-conditions',[PageController::class,'terms'])->name('terms');

Route::get('/shipping-policy',[PageController::class,'shipping'])->name('shipping.policy');

Route::get('/privacy-policy',[PageController::class,'privacy'])->name('privacy.policy');

Route::get('/faqs',[PageController::class,'faq'])->name('faq');
Route::get('/fragrances', [FrontendController::class, 'fragrances'])
    ->name('frontend.fragrances');
/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\AdminForgotPasswordController;

Route::get('/admin/forgot-password', [AdminForgotPasswordController::class, 'showForgotForm'])->name('admin.password.request');
Route::post('/admin/forgot-password', [AdminForgotPasswordController::class, 'sendOtp'])->name('admin.password.email');

Route::get('/admin/verify-otp', [AdminForgotPasswordController::class, 'showOtpForm'])->name('admin.otp.form');
Route::post('/admin/verify-otp', [AdminForgotPasswordController::class, 'verifyOtp'])->name('admin.otp.verify');

Route::get('/admin/reset-password', [AdminForgotPasswordController::class, 'showResetForm'])->name('admin.password.reset.form');
Route::post('/admin/reset-password', [AdminForgotPasswordController::class, 'resetPassword'])->name('admin.password.update');
Route::prefix('admin')->name('admin.')->group(function () {

    // ====================== ADMIN AUTH ======================
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // ====================== PROTECTED ADMIN ROUTES ======================
    Route::middleware('auth:admin')->group(function () {

        // Dashboard
        Route::get('/dashboard', [HomeController::class, 'dashboard'])
            ->name('dashboard');

        // Home Sections
        Route::get('/home', [HomeController::class, 'index'])
            ->name('home.manage');

        Route::post('/home', [HomeController::class, 'store'])
            ->name('home.store');

        Route::get('/home/{section}/edit', [HomeController::class, 'edit'])
            ->name('home.edit');

        Route::put('/home/{section}', [HomeController::class, 'update'])
            ->name('home.update');

        Route::delete('/home/{section}', [HomeController::class, 'destroy'])
            ->name('home.destroy');

        // Settings
        Route::get('/settings', [SettingController::class, 'edit'])
            ->name('settings.edit');

        Route::post('/settings', [SettingController::class, 'update'])
            ->name('settings.update');

        // ====================== PRODUCTS ======================
        Route::post('/products/bulk-discount', [ProductController::class, 'bulkDiscount'])
            ->name('products.bulk-discount');

        Route::delete('/products/bulk-delete', [ProductController::class, 'bulkDelete'])
            ->name('products.bulk-delete');

        Route::resource('categories', CategoryController::class);

        Route::resource('attributes', AttributeController::class);

        Route::resource('brands', BrandController::class)
            ->except(['show']);

        Route::resource('coupons', CouponController::class)
            ->except(['show']);

        Route::resource('products', ProductController::class)
            ->except(['show']);

        // ====================== ORDERS ======================
       // ====================== ORDERS ======================

Route::get('/orders-table', [OrderController::class, 'ordersTable'])
    ->name('orders.table');

Route::get('/invoices', [OrderController::class, 'invoiceList'])
    ->name('invoices.index');

Route::get('/invoices/{id}/download', [OrderController::class, 'invoice'])
    ->name('invoices.download');

Route::get('/orders/requests', [OrderController::class, 'requests'])
    ->name('orders.requests');

Route::get('/orders', [OrderController::class, 'index'])
    ->name('orders.index');

Route::get('/orders/{id}/invoice', [OrderController::class, 'invoice'])
    ->name('orders.invoice');

Route::get('/orders/{order_number}', [OrderController::class, 'detail'])
    ->name('orders.detail');

Route::post('/orders/{order_number}/status', [OrderController::class, 'updateStatus'])
    ->name('orders.status');
           
    });
    
});