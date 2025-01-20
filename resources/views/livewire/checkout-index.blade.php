
<div class="checkout-wrapper">
    <!-- Root element starts here -->
    {{-- @livewire('checkout')
    <!-- Embed the Livewire component --> --}}
        {{-- Display form validation errors --}}
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Display session error messages --}}
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        {{-- Display session success message --}}
        @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
        @endif
    <div class="container">
        <h1>Checkout</h1>


        {{-- Display cart items or empty message --}}
        @if($cartItems->isEmpty())
        <p>Your cart is empty.</p>
        @else
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
                @foreach($cartItems as $item)

                <tr wire:key="cart-item-{{ $item->id }}">
                    <!-- wire:key added for Livewire performance -->
                    <td>
                        @if ($item->product)
                        {{ $item->product->name }}
                        @else
                        <span class="text-danger">Product not available</span>
                        @endif
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->original_price, 2) }}</td>
                    <td>${{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="checkout-total">
            <p><strong>Cart Total:</strong> ${{ number_format($cartItems->sum('total_price'), 2) }}</p>
        </div>

        {{-- Checkout form --}}
        <form >

            Coupon Code
            <div class="form-group">
                <label for="coupon_code">Coupon Code (optional):</label>
                <input type="text" id="coupon_code" name="coupon_code" wire:model.lazy="form.couponCode"
                    class="form-control" placeholder="Enter coupon code" autocomplete="off">
                @error('couponCode') <span class="text-danger">{{ $message }}</span> @enderror
                <button type="submit" wire:click="applyCoupon" class="btn btn-secondary mt-2"
                    wire:loading.attr="disabled">
                    Apply Coupon
                </button>
                <div wire:loading>
                    <span>Applying coupon...</span>
                </div>
            </div>

            {{-- Shipping Method --}}
            <div class="form-group">
                <label for="selectedShippingMethod">Select Shipping Method:</label>
                <select id="selectedShippingMethod" wire:model.lazy="selectedShippingMethod" class="form-control"
                    required name="selectedShippingMethod">
                    @error('selectedShippingMethod')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    @foreach($shippingMethods as $method)
                    <option value="{{ $method->id }}">
                        {{ $method->name }} - ${{ number_format($method->cost, 2) }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Total with Shipping --}}
            <div class="checkout-total">
                <p><strong>Total (with Shipping):</strong> ${{ number_format($totalPrice, 2) }}</p>
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-primary" wire:click="proceedToPayment">Proceed to Payment</button>
            <div wire:loading>
                <p>Processing your payment, please wait...</p>
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

        </form>

        @endif
    </div>
</div> <!-- Root element ends here -->
