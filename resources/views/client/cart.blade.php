@extends('layouts.homeapp')

@section('content')

<h2>Your Cart</h2>
@if(session('cart'))
    <ul>
        @foreach(session('cart') as $id => $details)
            <li>
                {{ $details['name'] }} - ₹{{ $details['price'] }} x {{ $details['quantity'] }}
                <form method="POST" action="{{ route('cart.remove', $id) }}">
                    @csrf
                    <button type="submit">Remove</button>
                </form>
            </li>
        @endforeach
    </ul>
@else
    <p>Your cart is empty</p>
@endif
@endsection
