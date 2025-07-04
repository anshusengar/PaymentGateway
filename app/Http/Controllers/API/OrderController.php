<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'price' => 'required'
        ]);

        $order = Order::create([
            'pid' => $validated['product_id'],
            'userid' => auth()->id(), // takes logged-in user
            'qty' => $validated['qty'],
            'status' => 'pending',
             'price' => $validated['price'],
        ]);

        return response()->json($order);
    }
}
