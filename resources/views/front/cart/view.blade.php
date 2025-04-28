@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Your Cart</h2>

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

        @if ($cartItems->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total Price</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (Auth::check())
                        @foreach ($cartItems as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                            style="width: 60px;">
                                        <button type="submit" class="btn btn-sm btn-info">Update</button>
                                    </form>
                                </td>
                                <td>${{ number_format($item->product->price, 2) }}</td>
                                <td>${{ number_format($item->quantity * $item->final_price, 2) }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                        alt="{{ $item->product->name }}" width="50">
                                </td>
                                <td>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        @foreach ($cartItems as $id => $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                            min="1" style="width: 60px;">
                                        <button type="submit" class="btn btn-sm btn-info">Update</button>
                                    </form>
                                </td>
                                <td>${{ number_format($item['price'], 2) }}</td>
                                <td>${{ number_format($item['quantity'] * $item['price'], 2) }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}"
                                        width="50">
                                </td>
                                <td>
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>

            <div class="text-right">
                <h4>Total: ${{ number_format($total, 2) }}</h4>

                <div class="mt-3">
                    <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-warning">Clear Cart</button>
                    </form>

                    <a href="{{ route('checkout.index') }}" class="btn btn-success ml-2">Proceed to Checkout</a>
                </div>
            </div>
        @else
            <div class="alert alert-info">
                Your cart is empty. <a href="{{ route('products.index') }}">Continue shopping</a>
            </div>
        @endif
    </div>
@endsection
