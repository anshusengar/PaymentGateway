<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Services\CouponService;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);
    
        $quantity = $request->input('quantity', 1); // Default to 1 if no quantity is provided
    
        // Get current cart from session
        $cart = session()->get('cart', []);
    
        // If product is already in cart, update the quantity
        if(isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            // Otherwise, add product to the cart
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
    
        // Store updated cart in session
        session()->put('cart', $cart);
    
        // Redirect back with success message
        return redirect()->route('cart.view')->with('success', 'Product added to cart!');
    }
    public function viewCart()
{
    $cart = session()->get('cart');
    return view('client.cart', compact('cart'));
}
    





public function removeFromCart($id)
{
    $cart = session()->get('cart');

    if (isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }

    return redirect()->route('cart.view')->with('success', 'Product removed!');
}



public function applyCoupon(Request $request, CouponService $couponService)
{
    $coupon = Coupon::where('code', $request->coupon_code)->firstOrFail();
    $user = auth()->user();

    $cartTotal = 1500; // replace with real cart value
    $cartProducts = [
        ['id' => 1],
        ['id' => 5],
    ];
    $paymentMethod = $request->payment_method;

    if (!$couponService->isCouponApplicable($user, $coupon, $cartTotal, $cartProducts, $paymentMethod)) {
        return back()->withErrors(['coupon' => 'This coupon is not applicable to your cart.']);
    }

    // apply discount logic...
    return back()->with('success', 'Coupon applied successfully!');
}
}
