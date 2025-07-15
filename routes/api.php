<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CouponController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
Route::put('/user', [UserController::class, 'update']);

    Route::apiResource('users', UserController::class);

    Route::apiResource('products', ProductController::class);

Route::get('/user', [AuthController::class, 'user']);
Route::post('/create-razorpay-order', [ProductController::class, 'createRazorpayOrder']);
Route::post('/payment', [ProductController::class, 'payment']);

Route::post('/reviews', [ProductController::class, 'saveReviews']);
Route::post('/submit-rating', [ProductController::class, 'submitRating']);


Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/history', [OrderController::class, 'history']);
Route::apiResource('categories', CategoryController::class);
Route::get('/my-orders', [OrderController::class, 'myOrders']);
Route::get('/orders/{id}', [OrderController::class, 'orderDetail']);
Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel']);
Route::post('/orders/{id}/refund', [OrderController::class, 'refund']);



Route::post('/check-coupon', [CartController::class, 'checkCoupon'])->name('check.coupon');


Route::get('/available-coupons', [CouponController::class, 'index']);
Route::post('/check-coupon', [CouponController::class, 'validateCoupon']);

});
