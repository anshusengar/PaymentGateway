<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session; // ✅ Add this
use Stripe\Charge;
use App\Models\Order;
class PaymentGatewayController extends Controller
{
    public function checkoutForm()
    {
        return view('stripe.checkout');
    }

    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    
        $order = Order::findOrFail($request->order_id);
    
        $quantity = max(1, (int) $order->qty);
    
        $product = $order->product; // ✅ Now get product info from relation
    
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'inr', // your case
                    'product_data' => [
                        'name' => $product->name, // ✅ Correct
                    ],
                    'unit_amount' => (int) ($product->price * 100), // ✅ price * 100 (Stripe wants in paise)
                ],
                'quantity' => $quantity,
            ]],
            'mode' => 'payment',
            'success_url' => url('/checkout') . '?success=true',
            'cancel_url' => url('/checkout') . '?cancel=true',
        ]);
    
        return response()->json(['id' => $session->id]);
    }
} 