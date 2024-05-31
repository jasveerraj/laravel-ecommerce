<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('coupons', CouponController::class);
    Route::get('orders', [AdminController::class, 'orders'])->name('orders.index');
    Route::get('dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('orders/{id}', [AdminController::class, 'show'])->name('orders.show');
    Route::patch('orders/{id}/status', [AdminController::class, 'updateStatus'])->name('orders.updateStatus');
});


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/data', [CartController::class, 'getCartData'])->name('cart.data');
// Checkout routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');


Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('order.place');
Route::get('/order/success', [OrderController::class, 'showOrderSuccessPage'])->name('order.success');
Route::post('/apply-coupon', [OrderController::class, 'applyCoupon'])->name('apply.coupon');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





require __DIR__.'/auth.php';
