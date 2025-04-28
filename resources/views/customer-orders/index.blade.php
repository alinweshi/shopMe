<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Orders</h1>
        <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">Create New Order</a>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Order Date</th>
                    <th>Required Date</th>
                    <th>Shipped Date</th>
                    <th>Status</th>
                    <th>Customer Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->orderNumber }}</td>
                    <td>{{ $order->orderDate }}</td>
                    <td>{{ $order->requiredDate }}</td>
                    <td>{{ $order->shippedDate ?? 'Not Shipped' }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->customerNumber }}</td>
                    <td>
                        <a href="{{ route('customer-orders.show', $order->orderNumber) }}"
                            class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('customer-orders.edit', $order->orderNumber) }}"
                            class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('customer-orders.destroy', $order->orderNumber) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>