@extends('layouts.app')

@section('content')
<h1>Choose a Payment Method</h1>
@if(isset($paymentMethods['Data']) && count($paymentMethods['Data']) > 0)
<form method="POST" action="{{ route('payment.execute') }}">
@csrf
    <select name="payment_method_id" required>
        <!-- Add payment method options dynamically -->
        <option value="1">Visa</option>
        <option value="2">MasterCard</option>
    </select>
    <button type="submit">Pay Now</button>
</form>

@else
    <p>No payment methods available at the moment.</p>
@endif
@endsection
