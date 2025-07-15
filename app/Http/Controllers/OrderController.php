<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Mail\PaymentSuccessMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Jobs\SendOrderSuccessEmail;

class OrderController extends Controller
{
    public function index()
{
    $orders = Order::with('product')->get();
    return view('orders.index', compact('orders'));
}


    public function deliveredOrder()
{
    $orders = Order::where('status','delivered')->get();
    return view('orders.index', compact('orders'));
}


    public function pendingOrder()
{
    $orders = Order::where('status','pending')->get();
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
        $order->status = $request->status??'';
        $order->paymentmethod = $request->payment_method;
        $order->pid = $product->id; // Save the selected product ID
        $order->qty = $request->quantity;
        // Link the order to the logged-in user
        $order->userid = auth()->id();
    
        // Save the order
        $order->save();
     event(new \App\Events\OrderStatusUpdated($order));

        return redirect()->route('orders')->with('success', 'Order created successfully!');
    }
    



    public function delete($id){

        $orders=Order::find($id);
           $orders->delete();
           return redirect()->back()->with('success', 'Order Deleted successfully.');
    }
    
public function sendMail(Request $request)
{
    $order = Order::with('user')->find($request->order_id);

    if (!$order) {
        return response()->json(['success' => false, 'message' => 'Order not found']);
    }

    SendOrderSuccessEmail::dispatch($order);

    return response()->json(['success' => true, 'message' => 'Email sent successfully!']);
}



public function placeOrder(Request $request)
{
   $order = Order::create([
    'user_id' => auth()->id(),
    'amount' => $request->amount,
    'status' => 'pending',
]);
    // Dispatch the job to the queue
    SendOrderSuccessEmail::dispatch($order);

    return response()->json(['success' => true]);
}


public function updateStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);
    $order->status = $request->input('status');
    $order->save();

    // optionally fire the event here:
    event(new \App\Events\OrderStatusUpdated($order));

    return redirect()->back()->with('success', 'Order status updated!');
}

}
