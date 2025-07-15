<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;

class OrderController extends Controller
{
  public function store(Request $request)
{
    $validated = $request->validate([
        'product_id' => 'required|exists:products,id',
        'qty' => 'required|integer|min:1',
        'price' => 'required|numeric',
        'address' => 'required',
        'phone' => 'required',
        'pincode' => 'required',
        'city' => 'required',
        'state' => 'required',
        'size' => 'nullable|string',
        'coupon_code' => 'nullable|string',
    ]);

    // Fetch product and cart total
    $product = Product::findOrFail($validated['product_id']);
    $cartTotal = $product->price * $validated['qty'];

    // Coupon validation
    if (!empty($validated['coupon_code'])) {
        $coupon = Coupon::where('code', $validated['coupon_code'])->first();

        if (!$coupon) {
            return response()->json(['error' => 'Invalid coupon code.'], 400);
        }

        // Check expiry
        if ($coupon->expires_at && now()->greaterThan($coupon->expires_at)) {
            return response()->json(['error' => 'Coupon has expired.'], 400);
        }

        // Check min order
        if ($coupon->min_order_amount && $cartTotal < $coupon->min_order_amount) {
            return response()->json(['error' => 'Coupon valid only for orders above ₹' . $coupon->min_order_amount], 400);
        }

        // One-time use
        if ($coupon->is_one_time) {
            $alreadyUsed = DB::table('coupon_usages')
                ->where('coupon_id', $coupon->id)
                ->where('user_id', auth()->id())
                ->exists();

            if ($alreadyUsed) {
                return response()->json(['error' => 'You have already used this coupon.'], 400);
            }
        }
    }

    // Proceed with order saving
    $order = Order::create([
        'pid' => $validated['product_id'],
        'userid' => auth()->id(),
        'qty' => $validated['qty'],
        'size' => $validated['size'],
        'status' => 'pending',
        'price' => $validated['price'],
        'address' => $validated['address'],
        'phone' => $validated['phone'],
        'pincode' => $validated['pincode'],
        'city' => $validated['city'],
        'state' => $validated['state'],
        'coupon_code' => $validated['coupon_code'] ?? null,
    ]);

    return response()->json($order);
}



public function myOrders(Request $request)
{
    $userId = $request->user()->id;

    $orders = Order::where('userid', $userId)
        ->with('product') // so you also get product name, price, etc
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json($orders);
}

public function orderDetail($id, Request $request)
{
    $order = Order::with('product', 'user')->where('id', $id)
        ->where('userid', $request->user()->id)
        ->firstOrFail();

    return response()->json($order);
}


// In OrderController.php
public function cancel($id)
{
    $order = Order::findOrFail($id);

    if ($order->status === 'cancelled') {
        return response()->json(['success' => false, 'message' => 'Order is already cancelled.']);
    }

    if ($order->status !== 'pending') {
        return response()->json(['success' => false, 'message' => 'Only pending orders can be cancelled.']);
    }

    $order->status = 'cancelled';
    $order->cancelled_at = now();
    $order->save();

    return response()->json(['success' => true, 'message' => 'Order cancelled successfully.']);
}



// In OrderController.php
public function refund($id)
{
    $order = Order::findOrFail($id);

    if ($order->status !== 'paid') {
        return response()->json(['success' => false, 'message' => 'Only paid orders can be refunded.']);
    }

    // You can integrate Razorpay refund API here if needed
    $order->status = 'refunded';
    $order->refunded_at = now();
    $order->save();

    return response()->json(['success' => true, 'message' => 'Order refunded successfully.']);
}









}
