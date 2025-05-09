@extends('layouts.app')

@section('content')

<div class="w-full mt-20 p-8 space-y-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-gray-800">All Orders</h2>


    @if(session('success'))
    <div class="flex justify-between items-center p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
        <span>{{ session('success') }}</span>
        <button type="button" class="text-green-700" data-dismiss="alert" aria-label="Close" onclick="this.parentElement.style.display='none';">
            <span aria-hidden="true" class="text-xl font-bold">&times;</span>
        </button>
    </div>
@endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden shadow">
            <thead class="bg-gray-100 text-gray-700 text-sm">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Product Name</th>
                    <th class="px-6 py-3 text-left">Price</th>
                    <th class="px-6 py-3 text-left">Quantity</th>
                    <th class="px-6 py-3 text-left">Create Date</th>
                    <th class="px-6 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
                @foreach($orders as $index => $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">{{ $order->product->name }}</td>
                    <td class="px-6 py-4">{{ number_format($order->price, 2) }}</td>
                    <td class="px-6 py-4">{{ $order->qty }}</td>
                    <td class="px-6 py-4">{{ $order->created_at }}</td>
                    <td class="px-6 py-4 flex items-center space-x-2">
                    <button class="payButton bg-blue-600 text-white px-3 py-1 rounded" 
            data-order-id="{{ $order->id }}" 
            data-payment-method="{{ $order->paymentmethod }}">
            Pay Now
        </button>
                        <form action="{{ route('order.delete', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this Order?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-xs font-medium">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    const stripe = Stripe("{{ config('services.stripe.key') }}");

    // Select all buttons with class payButton
    const payButtons = document.querySelectorAll('.payButton');

    payButtons.forEach(button => {
        button.addEventListener('click', function () {
            const orderId = this.getAttribute('data-order-id');

            fetch("{{ route('create.checkout.session') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    order_id: orderId
                })
            })
            .then(response => response.json())
            .then(session => {
                return stripe.redirectToCheckout({ sessionId: session.id });
            })
            .then(result => {
                if (result.error) {
                    alert(result.error.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
        });
    });
</script>

@endsection
