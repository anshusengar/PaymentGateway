<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\User;

class CouponController extends Controller
{
   

 public function index()
    {
        $coupons = Coupon::latest()->get(); 

        return view('coupons.index', compact('coupons'));
    }

public function store(Request $request)
{
    $request->validate([
        'code' => 'required|string|unique:coupons,code',
        'type' => 'required|in:percentage,fixed',
        'value' => 'required|numeric|min:0',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'min_cart_value' => 'nullable|numeric|min:0',
        'is_new_user_only' => 'nullable|boolean',
        'applicable_users' => 'nullable|array',
        'applicable_products' => 'nullable|array',
        'payment_methods' => 'nullable|array',
    ]);

    Coupon::create([
        'code' => $request->code,
        'type' => $request->type,
        'value' => $request->value,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'min_cart_value' => $request->min_cart_value,
        'is_new_user_only' => $request->boolean('is_new_user_only'),
        'applicable_users' => $request->applicable_users ? json_encode($request->applicable_users) : null,
        'applicable_products' => $request->applicable_products ? json_encode($request->applicable_products) : null,
        'payment_methods' => $request->payment_methods ? json_encode($request->payment_methods) : null,
    ]);

    return redirect()->route('coupons.index')->with('success', 'Coupon created successfully.');
}

public function destroy($id)
{
    Coupon::findOrFail($id)->delete();
    return back()->with('success', 'Coupon deleted successfully.');
}



public function assignToUser(Request $request)
{
    $request->validate([
        'coupon_id' => 'required|exists:coupons,id',
        'user_id' => 'required|exists:users,id',
    ]);

    $coupon = Coupon::find($request->coupon_id);
    $coupon->users()->syncWithoutDetaching([$request->user_id]);

    return back()->with('success', 'Coupon assigned to user successfully.');
}


public function check(Request $request)
{
    $user = auth()->user();
    $coupon = Coupon::where('code', $request->coupon_code)->first();

    if (!$coupon) {
        return response()->json(['success' => false, 'message' => 'Invalid coupon code']);
    }

    // Check if this coupon has already been used by the user
    $alreadyUsed = DB::table('coupon_usages')
        ->where('user_id', $user->id)
        ->where('coupon_id', $coupon->id)
        ->exists();

    if ($alreadyUsed) {
        return response()->json(['success' => false, 'message' => 'Coupon already used']);
    }

    // Optional: Save usage immediately OR after payment
    DB::table('coupon_usages')->insert([
        'user_id' => $user->id,
        'coupon_id' => $coupon->id,
        'used_at' => now(),
    ]);

    $discount = $coupon->discount; // use percentage or fixed
    $total = $request->cart_total;

    $discountedAmount = $total - ($discount / 100 * $total); // adjust if fixed

    return response()->json([
        'success' => true,
        'message' => 'Coupon applied successfully!',
        'discount' => round($total - $discountedAmount),
        'new_total' => round($discountedAmount),
    ]);
}


}
