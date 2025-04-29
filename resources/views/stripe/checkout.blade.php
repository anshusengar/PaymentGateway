<!DOCTYPE html>
<html>
<head>
    <title>Stripe Payment</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
@if(session('success'))
    <h3 style="color:green">{{ session('success') }}</h3>
@endif
@if(session('error'))
    <h3 style="color:red">{{ session('error') }}</h3>
@endif

<form id="payment-form">
    @csrf
    <button type="button" id="payButton">Pay $10</button>
</form>

<script>
    const stripe = Stripe("{{ config('services.stripe.key') }}");

    document.getElementById('payButton').addEventListener('click', function () {
        fetch("{{ route('create.checkout.session') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
            body: JSON.stringify({
                product_id: {{ $product->id }}
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
</script>
</body>
</html>
