<div>
    {{-- The whole world belongs to you. --}}
</div>
@extends('layouts.app')

@section('content')
<h1>Choose a Payment Method</h1>
@if(isset($paymentMethods['Data']) && count($paymentMethods['Data']) > 0)
    <ul>
        @foreach($paymentMethods['Data']['PaymentMethods'] as $method)
            <li>
                <img src="{{ $method['ImageUrl'] }}" alt="{{ $method['PaymentMethodEn'] }}">
                <span>{{ $method['PaymentMethodEn'] }} ({{ $method['PaymentCurrencyIso'] }})</span>
                <form action="{{ route('payment.execute') }}" method="post">
                    @csrf
                    <input type="hidden" name="payment_method_id" value="{{ $method['PaymentMethodId'] }}">
                    <button type="submit">Choose</button>
                </form>
            </li>
        @endforeach
    </ul>
@else
    <p>No payment methods available at the moment.</p>
@endif
@endsection
