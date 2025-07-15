<?php

namespace App\Services;

use App\Models\Coupon;
use Illuminate\Support\Facades\DB;

class CouponService
{
    public function isCouponApplicable($user, Coupon $coupon, $cartTotal, array $products, $paymentMethod)
    {
        // 1. Expiry Check
        if ($coupon->expires_at && now()->gt($coupon->expires_at)) {
            return ['success' => false, 'message' => 'This coupon has expired.'];
        }

        // 2. Minimum Amount Check
       if ($coupon->min_order_amount && $cartTotal < $coupon->min_order_amount) {
    \Log::info("Minimum order check failed", [
        'required' => $coupon->min_order_amount,
        'given' => $cartTotal
    ]);

    return [
        'success' => false,
        'message' => 'Minimum order amount to use this coupon is ₹' . $coupon->min_order_amount
    ];
}


        // 3. One-time use per user
        if ($coupon->is_one_time && $user) {
            $alreadyUsed = DB::table('coupon_usages')
                ->where('coupon_id', $coupon->id)
                ->where('user_id', $user->id)
                ->exists();

            if ($alreadyUsed) {
                return ['success' => false, 'message' => 'You have already used this coupon.'];
            }
        }

        // 4. (Optional) Restrict to specific payment method
        if ($coupon->allowed_payment_method && $coupon->allowed_payment_method !== $paymentMethod) {
            return ['success' => false, 'message' => 'This coupon is not valid for this payment method.'];
        }

        // 5. (Optional) Restrict to product categories, brands, etc.

        return true; // ✅ All checks passed
    }
}
