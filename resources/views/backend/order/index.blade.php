@extends('layouts.app')
<!-- Extend your layout -->

@section('content')
<div class="container">
    <h1 class="mb-4">Orders</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Total Price</th>
                <th>Tax Amount</th>
                <th>Total with Tax</th>
                <th>Status</th>
                <th>Payment Method</th>
                <th>Order Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name ?? 'Guest' }}</td> <!-- Assuming user relationship -->
                <td>${{ number_format($order->total_price, 2) }}</td>
                <td>${{ number_format($order->tax_amount, 2) }}</td>
                <td>${{ number_format($order->total_with_tax, 2) }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>{{ ucfirst($order->payment_method ?? 'N/A') }}</td>
                <td>{{ $order->order_date}}</td>
                <td>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PUT')
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing
                            </option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                            <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled
                            </option>
                            <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>Refunded
                            </option>
                            <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $orders->links() }}
    <!-- Pagination links -->
</div>
@endsection