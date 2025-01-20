@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order Confirmation</h1>

    <div class="alert alert-success">
        <strong>Success!</strong> Your order has been placed successfully.
    </div>

    <div class="card mb-3">
        <div class="card-header">Order Summary</div>
        <div class="card-body">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
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

    <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
</div>
@endsection