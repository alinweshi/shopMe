@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order #{{ $order->id }}</h1>

    <div class="card mb-3">
        <div class="card-header">Order Details</div>
        <div class="card-body">
            <p><strong>User:</strong> {{ $order->user->name ?? 'Guest' }}</p>
            <p><strong>Total Price:</strong> ${{ $order->total_price }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Order Date:</strong> {{ $order->order_date }}</p>
            <p><strong>Shipping Address:</strong> {{ $order->shipping_address }}</p>
            <p><strong>Billing Address:</strong> {{ $order->billing_address }}</p>
        </div>
    </div>

    <h2>Order Items</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ $item->unit_price }}</td>
                <td>${{ $item->total_price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Checkout Button -->
    <a href="{{ route('checkout.index', ['order_id' => $order->id]) }}" class="btn btn-success">Checkout</a>

    <a href="{{ route('orders.index') }}" class="btn btn-primary">Back to Orders</a>
</div>
@endsection