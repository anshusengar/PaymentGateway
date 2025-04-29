<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');  // for login page directly
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/checkout', [PaymentGatewayController::class, 'checkoutForm'])->name('checkout');
    Route::post('/create-checkout-session', [PaymentGatewayController::class, 'createCheckoutSession'])->name('create.checkout.session');


    //product
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::get('/create-product', [ProductController::class, 'create'])->name('create.product');
   Route::post('/save-product', [ProductController::class, 'store'])->name('product.store');
   Route::delete('/delete-product/{id}', [ProductController::class, 'delete'])->name('product.delete');


//order
Route::get('/orders', [OrderController::class, 'index'])->name('orders');
Route::get('/create-order', [OrderController::class, 'create'])->name('create.order');
Route::post('/save-order', [OrderController::class, 'store'])->name('order.store');
Route::delete('/delete-order/{id}', [OrderController::class, 'delete'])->name('order.delete');
Route::post('/create-ccavenue-session', [PaymentGatewayController::class, 'createCcavenueSession'])->name('ccavenue.checkout.session');
// routes/web.php
Route::post('/paypal-checkout-session', [PaymentGatewayController::class, 'createPayPalSession'])->name('paypal.checkout.session');


});

require __DIR__.'/auth.php';
