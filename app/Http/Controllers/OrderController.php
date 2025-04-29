<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
{
    $orders = Order::with('product')->get();
    return view('orders.index', compact('orders'));
}

    public function create(){
        $products=Product::all();
        return view('orders.create',compact('products'));
    }


    public function store(Request $request)
    {
        // Validate form data
        $request->validate([
            'payment_method' => 'required|string',
            'pid' => 'required|exists:products,id', // Ensure the product exists
        ]);
    
        // Find the selected product by ID
        $product = Product::find($request->pid);
        $totalPrice = $product->price * $request->quantity;
        // Create new order
        $order = new Order();
        $order->price =  $totalPrice; // Automatically set product price
        $order->description = $request->description??'';
        $order->paymentmethod = $request->payment_method;
        $order->pid = $product->id; // Save the selected product ID
        $order->qty = $request->quantity;
        // Link the order to the logged-in user
        $order->userid = auth()->id();
    
        // Save the order
        $order->save();
    
        return redirect()->route('orders')->with('success', 'Order created successfully!');
    }
    



    public function delete($id){

        $orders=Order::find($id);
           $orders->delete();
           return redirect()->back()->with('success', 'Order Deleted successfully.');
    }
    

}
