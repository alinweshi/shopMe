@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Order #{{ $order->id }}</h1>

    <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="status">Order Status</label>
            <select name="status" id="status" class="form-control">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                <option value="failed" {{ $order->status == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
@endsection