<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
   public function index()
{
    $today = now();

    $coupons = Coupon::where('status', 'active')
        ->where(function ($q) use ($today) {
            $q->whereNull('end_date')
              ->orWhere('end_date', '>=', $today);
        })
        ->where(function ($q) use ($today) {
            $q->whereNull('start_date')
              ->orWhere('start_date', '<=', $today);
        })
        ->get();

    return response()->json($coupons);
}

   public function validateCoupon(Request $request)
{
    $request->validate([
        'coupon_code' => 'required|string',
        'cart_total' => 'required|numeric',
        'user_id' => 'nullable|integer',
    ]);

    $coupon = Coupon::where('code', $request->coupon_code)->first();

    if (!$coupon) {
        return response()->json(['success' => false, 'message' => 'Invalid coupon code']);
    }

    $userId = $request->user_id ?? null;

    if (!$coupon->isValid($request->cart_total, $userId)) {
        return response()->json(['success' => false, 'message' => 'Coupon is not valid or has expired']);
    }

    $discount = $coupon->calculateDiscount($request->cart_total);
    $newTotal = $request->cart_total - $discount;

    return response()->json([
        'success' => true,
        'message' => 'Coupon applied successfully!',
        'discount' => $discount,
        'new_total' => $newTotal,
        'free_shipping' => $coupon->free_shipping,
    ]);
}

}
