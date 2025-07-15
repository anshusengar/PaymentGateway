<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Services\CouponService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function checkCoupon(Request $request, CouponService $couponService)
    {
        $request->validate([
            'coupon_code' => 'required|string',
            'cart_total' => 'required|numeric',
            'payment_method' => 'required|string',
            'products' => 'required|array', // array of { id: 1, name: 'Product' }
        ]);

        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Coupon not found.']);
        }

        $user = auth()->user(); // or fake one for testing
        $cartTotal = $request->cart_total;
        $cartProducts = $request->products;
        $paymentMethod = $request->payment_method;

        // ✅ Here we let service return either true or a message array
        $isApplicable = $couponService->isCouponApplicable($user, $coupon, $cartTotal, $cartProducts, $paymentMethod);

        if (is_array($isApplicable) && isset($isApplicable['success']) && $isApplicable['success'] === false) {
            return response()->json($isApplicable); // ← return detailed reason like minimum amount
        }

        // Calculate discount
        $discount = $coupon->type === 'fixed'
            ? $coupon->value
            : ($cartTotal * $coupon->value / 100);

        return response()->json([
            'success' => true,
            'discount' => $discount,
            'new_total' => $cartTotal - $discount,
            'message' => 'Coupon applied successfully!',
        ]);
    }
}
