<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\HomeController;
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Shop\OrderController as ShopOrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// TRANG KHÁCH HÀNG 
Route::get('/', [HomeController::class, 'index'])->name('shop.home');
Route::get('/products', [ShopController::class, 'index'])->name('shop.products');
Route::get('/products/{id}', [ShopController::class, 'show'])->name('shop.product.show');

// TRANG KHÁCH CẦN ĐĂNG NHẬP 
Route::middleware('auth')->group(function () {
    // Giỏ hàng
    Route::get('/cart', [CartController::class, 'index'])->name('shop.cart');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('shop.cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('shop.cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('shop.cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('shop.cart.checkout');

    // Thanh toán
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('shop.checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('shop.checkout.store');
    Route::get('/order-success/{id}', [CheckoutController::class, 'success'])->name('shop.checkout.success');

    // Đơn hàng của khách
    Route::get('/my-orders', [ShopOrderController::class, 'index'])->name('shop.orders');
    Route::get('/my-orders/{id}', [ShopOrderController::class, 'show'])->name('shop.order.show');
    Route::post('/my-orders/{id}/cancel', [ShopOrderController::class, 'cancel'])->name('shop.order.cancel');
});

// TRANG QUẢN TRỊ ADMIN 
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
});

require __DIR__.'/auth.php';