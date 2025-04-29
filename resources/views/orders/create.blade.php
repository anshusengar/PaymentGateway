@extends('layouts.app')

@section('content')

<div class="w-full mt-20 p-8 space-y-6 bg-white rounded-lg shadow-lg">
  <p class="text-xl font-bold text-gray-800 text-start">Create a New Order</p>

  @if(session('success'))
    <div class="flex justify-between items-center p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
        <span>{{ session('success') }}</span>
        <button type="button" class="text-green-700" data-dismiss="alert" aria-label="Close" onclick="this.parentElement.style.display='none';">
            <span aria-hidden="true" class="text-xl font-bold">&times;</span>
        </button>
    </div>
@endif

  <form action="{{route('order.store')}}" method="POST"  class="space-y-5">
    @csrf

    <div>
    <label for="pid" class="block mb-1 text-sm font-medium text-gray-700">Select Product</label>
    <select id="pid" name="pid" required
      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="updatePrice()">
      <option value="">Select Product</option>
      @foreach($products as $product)
        <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
      @endforeach
    </select>
  </div>


<div>
    <label for="quantity" class="block mb-1 text-sm font-medium text-gray-700">Quantity</label>
    <input type="number" id="quantity" name="quantity" min="1" value="1" required
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="updatePrice()">
</div>

<div>
    <label for="price" class="block mb-1 text-sm font-medium text-gray-700">Total Price</label>
    <input type="text" id="price" name="price" value="0.00" readonly
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-gray-100">
</div>

    <div>
  <label for="payment_method" class="block mb-1 text-sm font-medium text-gray-700">Payment Method</label>
  <select id="payment_method" name="payment_method" required
    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
    <option value="">-- Select Payment Method --</option>
    <option value="stripe">Stripe</option>
    <!-- You can add more options later if needed -->
  </select>
</div>

    <div>
      <label for="notes" class="block mb-1 text-sm font-medium text-gray-700">Description</label>
      <textarea id="notes" name="description" rows="3"
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
    </div>

    <button type="submit"
      class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
      Place Order
    </button>
  </form>
</div>

  <script>
    function updatePrice() {
      var selectedProduct = document.getElementById("pid");
      var quantity = document.getElementById("quantity").value;
      var priceField = document.getElementById("price");

      // Get the price from the selected option
      var price = selectedProduct.options[selectedProduct.selectedIndex].getAttribute("data-price");

      // If a product is selected, calculate the total price
      if (price && quantity > 0) {
        var totalPrice = price * quantity;
        priceField.value = totalPrice.toFixed(2); // Show price with 2 decimal places
      } else {
        priceField.value = "0.00"; // If no product is selected, show 0.00
      }
    }
  </script>
@endsection
