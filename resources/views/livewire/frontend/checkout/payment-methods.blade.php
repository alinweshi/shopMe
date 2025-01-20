<div class="payment-methods-wrapper"> <!-- Add a root element -->
    <h3>Select Payment Method</h3>
    <form wire:submit.prevent="submitPayment">
        <div class="form-group">
            <label for="payment_method">Payment Method:</label>
            <select wire:model="selectedPaymentMethod" class="form-control" required>
                @foreach($paymentMethods as $method)
                    <option value="{{ $method->id }}">
                        {{ $method->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Additional Payment Fields can be added here if needed --}}

        <button type="submit" class="btn btn-primary">Submit Payment</button>
    </form>
</div> <!-- Closed root element -->
