<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class Coupon extends Model
{
     protected $fillable = [
        'code',
        'type',
        'value',
        'max_discount',
        'min_purchase',
        'start_date',
        'end_date',
        'usage_limit',
        'used_count',
        'per_user_limit',
        'is_new_user_only',
        'free_shipping',
        'status',
        'applicable_on',
    ];
    

public function isValid($cartTotal, $userId = null)
{
    $now = Carbon::now();

    // Must be active
    if ($this->status !== 'active') return false;

    // Check date range
    if ($this->start_date && $now->lt(Carbon::parse($this->start_date))) return false;
    if ($this->end_date && $now->gt(Carbon::parse($this->end_date))) return false;

    // Check minimum purchase
    if ($this->min_purchase && $cartTotal < $this->min_purchase) return false;

    // Check overall usage limit
    if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;

    // Optional: Per-user limit check
    if ($userId && $this->per_user_limit) {
        $userUsedCount = \DB::table('coupon_usages')
            ->where('coupon_id', $this->id)
            ->where('user_id', $userId)
            ->count();

        if ($userUsedCount >= $this->per_user_limit) return false;
    }

    return true;
}

public function calculateDiscount($cartTotal)
{
    $discount = $this->type === 'percentage'
        ? ($this->value / 100) * $cartTotal
        : $this->value;

    if ($this->max_discount && $discount > $this->max_discount) {
        $discount = $this->max_discount;
    }

    return round($discount, 2);
}

}
