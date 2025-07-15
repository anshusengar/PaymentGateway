<?php

namespace App\Http\Controllers;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class RazorpayPaymentController extends Controller
{
  public function createRazorpayOrder(Request $request)
{
    $order = Order::findOrFail($request->order_id);
    $product = $order->product;

    $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

   $amount = $order->price * 100;// in paise

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
    $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

    $attributes = [
        'razorpay_order_id' => $request->razorpay_order_id,
        'razorpay_payment_id' => $request->razorpay_payment_id,
        'razorpay_signature' => $request->razorpay_signature
    ];

    try {
        $api->utility->verifyPaymentSignature($attributes);

        // Payment is successful
        // Save payment info to your DB here

        return response()->json(['success' => true]);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Payment verification failed']);
    }
}





}

