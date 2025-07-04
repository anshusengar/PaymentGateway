<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Razorpay\Api\Api;

use Illuminate\Http\Request;

use App\Http\Resources\ProductResource;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
       return response()->json($products);

    }

    // app/Http/Controllers/API/ProductController.php

public function show($id)
{
    $product = Product::findOrFail($id);
    return response()->json($product);
}



public function createRazorpayOrder(Request $request)
{
    $order = Order::findOrFail($request->order_id);
    $product = $order->product;

    $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

    $amount = $product->price * 100;

    $razorpayOrder = $api->order->create([
        'receipt'         => 'order_rcptid_' . $order->id,
        'amount'          => $amount,
        'currency'        => 'INR',
        'payment_capture' => 1,
    ]);

    return response()->json([
        'order_id'      => $razorpayOrder['id'],
        'amount'        => $amount,
        'currency'      => 'INR',
        'product_name'  => $product->name,
        'razorpay_key'  => config('services.razorpay.key'),
        'order_db_id'   => $order->id,
    ]);
}


public function payment(Request $request)
{
    try {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
        $api->utility->verifyPaymentSignature([
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        ]);
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        \Log::error('Razorpay verification failed: ' . $e->getMessage());
        return response()->json(['error' => 'Payment verification failed'], 500);
    }
}


}


