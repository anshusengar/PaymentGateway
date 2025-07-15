<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            background-color: #ffffff;
            max-width: 600px;
            margin: 20px auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .email-header {
            background-color: #4CAF50;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .email-body {
            padding: 20px;
        }
        .email-body p {
            color: #333;
            font-size: 15px;
            margin-bottom: 10px;
        }
        .product-image {
            text-align: center;
            margin: 20px 0;
        }
        .product-image img {
            max-width: 100%;
            border-radius: 8px;
            object-fit: cover;
        }
        .order-summary {
            margin-top: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 6px;
        }
        .email-footer {
            background-color: #f0f0f0;
            color: #777;
            text-align: center;
            font-size: 12px;
            padding: 15px;
        }
        .cta-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>Order Placed Successfully</h2>
        </div>

        <div class="email-body">
            <h3>Hi {{ $order->user->name ?? $order->name ?? 'Customer' }},</h3>

            <p>Your order <strong>(ID: #{{ $order->id }})</strong> has been placed successfully.</p>
            <p>Thank you for shopping with us! We’ll notify you once it's shipped. 🛍️</p>

            <div class="product-image">
                @if($product->image)
                    <img src="{{ url('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 200px;">
                @else
                    <p>No image available</p>
                @endif
            </div>

            <div class="order-summary">
                <h4>Order Summary:</h4>
                <p><strong>Product:</strong> {{ $product->name }}</p>
                <p><strong>Price:</strong> ₹{{ $order->price }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            </div>

            <div class="order-summary">
                <h4>Shipping Address:</h4>
                <p>
                    {{ $order->address }}<br>
                    {{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}<br>
                    Phone: {{ $order->phone }}
                </p>
            </div>

            <p style="text-align: center;">
                <a href="{{ url('/') }}" class="cta-button">Continue Shopping</a>
            </p>
        </div>

        <div class="email-footer">
            &copy; {{ date('Y') }} YourCompanyName. All rights reserved.
        </div>
    </div>
</body>
</html>
