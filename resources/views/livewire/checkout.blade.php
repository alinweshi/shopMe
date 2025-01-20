@extends('layouts.app')

@section('content')
<div class="checkout-container">
    <h2>Checkout</h2>

    <div class="cart-items">
        @foreach($cartItems as $item)
            <div class="cart-item">
                <h4>{{ $item['name'] }}</h4>
                <p>Quantity: {{ $item['quantity'] }}</p>
                <p>Price: {{ $item['total_price'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="shipping-methods">
        <h3>Shipping Methods</h3>
        <select id="shipping-method" name="shipping_method">
            @foreach($shippingMethods as $method)
                <option value="{{ $method['id'] }}">{{ $method['name'] }} - {{ $method['cost'] }}</option>
            @endforeach
        </select>
    </div>

    <div class="coupon-section">
        <h3>Apply Coupon</h3>
        <input type="text" id="coupon-code" placeholder="Enter coupon code" />
        <button id="apply-coupon">Apply Coupon</button>
    </div>

    <div class="total-price">
        <h3>Total Price: <span id="total-amount">{{ $totalPrice }}</span></h3>
    </div>

    <button id="proceed-to-payment">Proceed to Payment</button>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#apply-coupon').click(function() {
            const couponCode = $('#coupon-code').val();
            const selectedShippingMethod = $('#shipping-method').val();

            $.ajax({
                url: '{{ route("checkout.applyCoupon") }}',
                method: 'POST',
                data: {
                    coupon_code: couponCode,
                    selected_shipping_method: selectedShippingMethod,
                    _token: '{{ csrf_token() }}' // CSRF token for security
                },
                success: function(response) {
                    $('#total-amount').text(response.totalPrice);
                    alert(response.couponSuccess);
                },
                error: function(xhr) {
                    alert(xhr.responseJSON.errors.coupon[0]); // Display error message
                }
            });
        });

        $('#proceed-to-payment').click(function() {
            const totalPrice = $('#total-amount').text();
            const selectedShippingMethod = $('#shipping-method').val();
            const couponCode = $('#coupon-code').val();

            $.ajax({
                url: '{{ route("checkout.proceedToPayment") }}',
                method: 'POST',
                data: {
                    total_price: totalPrice,
                    selected_shipping_method: selectedShippingMethod,
                    coupon_code: couponCode,
                    _token: '{{ csrf_token() }}' // CSRF token for security
                },
                success: function(response) {
                    window.location.href = response.paymentUrl; // Redirect to payment URL
                },
                error: function(xhr) {
                    alert(xhr.responseJSON.error); // Display error message
                }
            });
        });
    });
</script>
@endsection
