<!DOCTYPE html>
<html>
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
        }
        .product-image {
            text-align: center;
            margin-top: 20px;
        }
        .product-image img {
            max-width: 100%;
            border-radius: 8px;
            object-fit: cover;
        }
        .email-footer {
            background-color: #f0f0f0;
            color: #777;
            text-align: center;
            font-size: 12px;
            padding: 15px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>Order Placed Successfully</h2>
        </div>
        <div class="email-body">
            <h3>Hi {{ $order->user->name ?? 'Customer' }},</h3>
            <p>Your order <strong>(ID: {{ $order->id }})</strong> has been placed successfully.</p>
            <p>Thank you for shopping with us! We’ll notify you when your order is shipped.</p>

            <div class="product-image">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        style="width: 200px;"/>
                @else
                    <p>No image available</p>
                @endif
            </div>
        </div>
        <div class="email-footer">
            &copy; {{ date('Y') }} Your Company Name. All rights reserved.
        </div>
    </div>
</body>
</html>
