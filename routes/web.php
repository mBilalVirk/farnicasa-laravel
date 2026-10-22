<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\ManagementController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShopController::class, 'home'])->name('home');
Route::get('/shop', [ShopController::class, 'catalog'])->name('shop');
Route::get('/categories/{category}', [ShopController::class, 'category'])->name('categories.show');
Route::get('/products/{product}', [ShopController::class, 'product'])->name('products.show');
Route::get('/about', [ShopController::class, 'about'])->name('about');
Route::get('/contact', [ShopController::class, 'contact'])->name('contact');
Route::post('/contact', [ShopController::class, 'contactSubmit'])->middleware('throttle:5,1')->name('contact.submit');
Route::post('/newsletter', [ShopController::class, 'newsletter'])->middleware('throttle:10,1')->name('newsletter.subscribe');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');
Route::delete('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:6,1');
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:6,1');
});
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::middleware(['auth', 'active'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'place'])->middleware('throttle:5,1')->name('checkout.place');
    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/account/orders/{order}', [AccountController::class, 'showOrder'])->name('account.orders.show');
    Route::get('/account/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::patch('/account/profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');
    Route::patch('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
    Route::post('/products/{product}/reviews', [ShopController::class, 'review'])->middleware('throttle:5,1')->name('reviews.store');
});
Route::prefix('admin')->name('admin.')->middleware(['auth', 'active', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::get('inventory', [InventoryController::class, 'index'])->name('inventory.index');
    Route::post('inventory/{product}/adjust', [InventoryController::class, 'adjust'])->name('inventory.adjust');
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::resource('coupons', CouponController::class)->except(['show']);
    Route::get('customers', [ManagementController::class, 'customers'])->name('customers.index');
    Route::patch('customers/{user}/toggle', [ManagementController::class, 'toggleCustomer'])->name('customers.toggle');
    Route::get('reviews', [ManagementController::class, 'reviews'])->name('reviews.index');
    Route::patch('reviews/{review}/approve', [ManagementController::class, 'approveReview'])->name('reviews.approve');
    Route::delete('reviews/{review}', [ManagementController::class, 'destroyReview'])->name('reviews.destroy');
    Route::get('settings', [ManagementController::class, 'settings'])->name('settings.index');
    Route::patch('settings', [ManagementController::class, 'updateSettings'])->name('settings.update');
    Route::get('contacts', [ManagementController::class, 'contacts'])->name('contacts.index');
    Route::patch('contacts/{message}/read',[ManagementController::class, 'readContact'])->name('contacts.read');
    Route::get('newsletters',[ManagementController::class, 'newsletters'])->name('newsletters.index');
});
