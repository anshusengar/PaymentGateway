<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Razorpay\Api\Api;
use App\Events\ProductUpdated;
use Illuminate\Http\Request;
use App\Jobs\SendOrderSuccessEmail;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File; // Add this if using File::exists()
use App\Http\Resources\ProductResource;
use App\Models\Review;


class ProductController extends Controller
{
  public function index(Request $request)
{
    $query = Product::query();

    // Filter by category ID
    if ($request->has('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    // Filter by search keyword
    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%');
        });
    }

    // Fetch products and parse sizes
    $products = $query->get()->map(function ($product) {
        $product->sizes = explode(',', $product->sizes);
         broadcast(new ProductUpdated($product))->toOthers();
        return $product;
    });

    return response()->json($products);
}



    // app/Http/Controllers/API/ProductController.php

public function show($id)
{
    $product = Product::with('images', 'reviews')->findOrFail($id);

// Calculate average rating & review count
$product->average_rating = round($product->reviews->avg('rating'), 1);
$product->review_count = $product->reviews->count();

    // Convert sizes string into array
    $product->sizes = explode(',', $product->sizes);

    // Convert image paths to full URLs
 $product->images = $product->images->map(function ($img) {
    return asset('storage/' . $img->image_path);
});

    // Attach average rating
    
    return response()->json($product);
}




public function createRazorpayOrder(Request $request)
{
    $order = Order::findOrFail($request->order_id);
    $product = $order->product;

    $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

   $amount = $order->price * 100; 

    $razorpayOrder = $api->order->create([
        'receipt'         => 'order_rcptid_' . $order->id,
        'amount'          => $amount,
        'currency'        => 'INR',
        'payment_capture' => 1,
    ]);

    return response()->json([
        'order_id'      => $razorpayOrder['id'],
        'amount'        => $amount,
        'currency'      => 'INR',
        'product_name'  => $product->name,
        'razorpay_key'  => config('services.razorpay.key'),
        'order_db_id'   => $order->id,
    ]);
}




public function payment(Request $request)
{
    DB::beginTransaction();

    try {
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        // 1. Verify Razorpay signature
        $api->utility->verifyPaymentSignature([
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        ]);

        // 2. Find matching order
        $order = Order::where('razorpay_order_id', $request->razorpay_order_id)->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        // 3. Check coupon one-time usage BEFORE proceeding
        if ($order->coupon_code) {
            $coupon = Coupon::where('code', $order->coupon_code)->first();

            if ($coupon) {
                $alreadyUsed = DB::table('coupon_user')
    ->where('coupon_id', $coupon->id)
    ->where('user_id', auth()->id())
    ->where('times_used', '>=', 1)
    ->exists();

if ($alreadyUsed) {
    return response()->json([
        'success' => false,
        'message' => 'You have already used this coupon.'
    ]);
}
            }
        }

        // 4. Update order as paid
        $order->update([
            'status' => 'paid',
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'payment_verified_at' => now()
        ]);

        // 5. Generate PDF invoice
        $invoicePath = storage_path('app/public/invoices');
        if (!file_exists($invoicePath)) {
            mkdir($invoicePath, 0755, true);
        }

        $filename = 'invoice_' . $order->id . '.pdf';
        $pdf = Pdf::loadView('pdf.invoice', [
            'order' => $order
        ]);
        $pdf->save($invoicePath . '/' . $filename);

        // 6. Update invoice path in order
        $order->update([
            'invoice_path' => 'invoices/' . $filename
        ]);

        // 7. Send confirmation email
        dispatch(new SendOrderSuccessEmail($order->id));

        // 8. Save coupon usage if valid
        if (isset($coupon)) {
            $coupon->increment('used_count');

            DB::table('coupon_usages')->insert([
                'coupon_id' => $coupon->id,
                'user_id' => $order->user_id ?? 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        DB::commit();

        return response()->json(['success' => true]);

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Razorpay verification failed: ' . $e->getMessage());

        return response()->json(['error' => 'Payment verification failed'], 500);
    }
}



public function saveReview(Request $request) {
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'rating' => 'required|integer|between:1,5',
        'comment' => 'nullable|string',
    ]);

    $review = new \App\Models\Review();
    $review->product_id = $request->product_id;
    $review->user_id = auth()->id(); // user must be logged in
    $review->rating = $request->rating;
    $review->comment = $request->comment;
    $review->save();

    return response()->json(['success' => true]);

}

 public function submitRating(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id', // or auth()->id()
            'order_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json(['message' => 'Rating submitted successfully.']);
    }

}
