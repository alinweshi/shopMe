@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Cart</h2>
    <!-- resources/views/layouts/app.blade.php -->
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if($cartItems)
    <table border="1" cellspacing="0" cellpadding="5">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            @if(Auth::check())
            @foreach ($cartItems as $item)
            <!-- Authenticated user -->
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->product->price }}</td>
                <td>{{ $item->total_price }}</td>
                <td><img src="/path/to/images/{{ $item->product->image }}" alt="{{ $item->product->name }}" width="50">
                </td>
            </tr>
            @endforeach
            @else
            @foreach ($cartItems as $item)
            <!-- Guest user -->
            <tr>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['quantity'] }}</td>
                <td>{{ $item['price'] }}</td>
                <td>{{ $item['quantity'] * $item['price'] }}</td>
                <td><img src="/path/to/images/{{ $item['image'] }}" alt="{{ $item['name'] }}" width="50"></td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
    @else
    <p>Your cart is empty.</p>
    @endif

    <!-- Display Total -->
    <h4>Total: ${{ number_format($total, 2) }}</h4>

    <!-- Clear Cart Form -->
    <form action="{{ route('cart.clear') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-warning">Clear Cart</button>
    </form>

    <!-- Proceed to Checkout -->
    <a href="{{ route('checkout.index') }}" class="btn btn-success">Proceed to Checkout</a>
</div>
@endsection