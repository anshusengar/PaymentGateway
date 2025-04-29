<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Order;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Payer;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

class PaymentGatewayController extends Controller
{
    protected $client;

    public function __construct()
    {
        // PayPal API context setup
        $environment = new SandboxEnvironment(env('PAYPAL_CLIENT_ID'), env('PAYPAL_CLIENT_SECRET'));
        $this->client = new PayPalHttpClient($environment);
    }

    public function createPayPalSession(Request $request)
    {
        // Find the order based on the order ID passed in the request
        $order = Order::findOrFail($request->order_id);

        // Create the order request
        $orderRequest = new OrdersCreateRequest();
        $orderRequest->prefer('return=representation');
        $orderRequest->body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                0 => [
                    'amount' => [
                        'currency_code' => 'INR',
                        'value' => number_format((float) $order->price, 2, '.', '')
                    ],
                    'description' => 'Payment for Order #' . $order->id
                ]
            ],
            'application_context' => [
                'return_url' => url('/checkout') . '?success=true',
                'cancel_url' => url('/checkout') . '?cancel=true'
            ]
        ];

        // Call the PayPal API to create the order
        try {
            $response = $this->client->execute($orderRequest);
            $approvalUrl = $response->result->links[1]->href; // Get the approval URL

            return response()->json(['approval_url' => $approvalUrl]);

        } catch (HttpException $ex) {
            // Handle error
            \Log::error('PayPal API Error: ' . $ex->getMessage());
            return response()->json(['error' => 'Error creating PayPal session: ' . $ex->getMessage()]);
        }
    }

    public function checkoutForm()
    {
        return view('stripe.checkout');
    }

    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $order = Order::findOrFail($request->order_id);

        $quantity = max(1, (int) $order->qty);

        $product = $order->product;

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'inr',
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount' => (int) ($product->price * 100),
                ],
                'quantity' => $quantity,
            ]],
            'mode' => 'payment',
            'success_url' => url('/checkout') . '?success=true',
            'cancel_url' => url('/checkout') . '?cancel=true',
        ]);

        return response()->json(['id' => $session->id]);
    }

    public function createCcavenueSession(Request $request)
    {
        $order = Order::findOrFail($request->order_id);

        $workingKey = env('WORKING_KEY');
        $accessCode = env('ACCESS_CODE');
        $merchantId = env('MERCHANT_ID');
        $redirectUrl = url('/checkout') . '?success=true'; // Same as Stripe success
        $cancelUrl = url('/checkout') . '?cancel=true';    // Same as Stripe cancel

        $amount = number_format($order->price, 2, '.', '');

        $merchantData = [
            'merchant_id'    => $merchantId,
            'order_id'       => $order->id,
            'currency'       => 'INR',
            'amount'         => $amount,
            'redirect_url'   => $redirectUrl,
            'cancel_url'     => $cancelUrl,
            'language'       => 'EN',
            'billing_name'   => $order->user->name ?? 'Customer',
            'billing_email'  => $order->user->email ?? 'test@example.com',
        ];

        $merchantDataString = '';
        foreach ($merchantData as $key => $value) {
            $merchantDataString .= $key . '=' . urlencode($value) . '&';
        }

        $encryptedData = $this->encrypt($merchantDataString, $workingKey);

        return response()->json([
            'encRequest' => $encryptedData,
            'accessCode' => $accessCode,
            'url' => env('CCAVENUE_URL'), // Example: https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction
        ]);
    }

    private function encrypt($plainText, $key)
    {
        $key = md5($key);
        $key = pack('H*', $key);
        $iv = pack('H*', "00000000000000000000000000000000");
        $encryptedText = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
        return bin2hex($encryptedText);
    }

   
    
}
