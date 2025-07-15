<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td, th { padding: 8px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <h2>Invoice #{{ $order->id }}</h2>
    <p><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
    <p><strong>Customer:</strong> {{ $order->user->name }}</p>

    <h4>Shipping Address:</h4>
    <p>{{ $order->address }}, {{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}</p>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $order->product->name }}</td>
                <td>1</td>
                <td>₹{{ $order->price }}</td>
            </tr>
        </tbody>
    </table>

    <h3>Total: ₹{{ $order->price }}</h3>
</body>
</html>
