<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('users', UserController::class);

    Route::apiResource('products', ProductController::class);

Route::get('/user', [AuthController::class, 'user']);
Route::post('/create-razorpay-order', [ProductController::class, 'createRazorpayOrder']);
Route::post('/payment', [ProductController::class, 'payment']);

Route::post('/orders', [OrderController::class, 'store']);

});
