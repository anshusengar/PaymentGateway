@extends('layouts.app')

@section('content')
<div class="p-6">
  <h2 class="text-2xl font-bold mb-4">Search Results for "{{ $query }}"</h2>

  <!-- Products -->
  <h3 class="text-xl font-semibold mt-6 mb-2 text-purple-700">Products</h3>
  @if($products->isEmpty())
    <p>No products found.</p>
  @else
    <ul class="space-y-2">
      @foreach($products as $product)
        <li class="border p-3 rounded bg-white shadow-sm">
          <strong>{{ $product->name }}</strong><br>
          ₹{{ $product->price }}
        </li>
      @endforeach
    </ul>
  @endif

  <!-- Orders -->
 
</div>
@endsection
