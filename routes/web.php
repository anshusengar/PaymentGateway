<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RazorpayPaymentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;


Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::get('/about', [HomeController::class, 'about'])->name('about');
    Route::get('/products', [HomeController::class, 'products'])->name('products');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::get('/send-notifications', [NotificationController::class, 'sendToAllUsers'])->name('send.notifications');


    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');



// Razorpay order creation (AJAX call)
Route::post('/create-razorpay-order', [RazorpayPaymentController::class, 'createRazorpayOrder'])->name('razorpay.createOrder');
Route::post('/payment', [RazorpayPaymentController::class, 'payment'])->name('razorpay.payment');

Route::post('/send-mail', [OrderController::class, 'sendMail'])->name('order.sendmail');

Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');

Route::get('/admin-chat', function() {
    return view('admin-chat');
})->middleware('auth');

Route::get('/login', function () {
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
Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
Route::get('/order-search', function() {
    $results = App\Models\Order::search(request('q'))->get();
    return response()->json($results);
});





Route::post('/create-ccavenue-session', [PaymentGatewayController::class, 'createCcavenueSession'])->name('ccavenue.checkout.session');
// routes/web.php
Route::post('/paypal-checkout-session', [PaymentGatewayController::class, 'createPayPalSession'])->name('paypal.checkout.session');



Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('/send-announcement', [UserController::class, 'announcement'])->name('send.announcement');

});
Route::get('/map', function () {
    return view('orders.googlemap'); // will create resources/views/map.blade.php
});

require __DIR__.'/auth.php';
