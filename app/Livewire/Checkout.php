<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\ShippingMethod;
use App\Services\MyFatoorahService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Checkout extends Component
{
    public $cartItems = [];
    public $shippingMethods = [];
    public $selectedShippingMethod = null;
    public $totalPrice = 0.0;
    public $couponCode = '';
    public $couponError = '';
    public $couponSuccess = '';

    protected $myfatoorahService;


    public function mount()
    {
        $this->myfatoorahService = app(MyFatoorahService::class);

        $this->loadCartItems();
        $this->loadShippingMethods();
        $this->calculateTotalPrice();
    }

    protected function loadCartItems()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)
            ->with(['cartItems.product:id,name,price'])
            ->first();

        if ($cart) {
            $this->cartItems = $cart->cartItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->product->name ?? 'Product not available',
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price ?? 0,
                    'total_price' => $item->total_price,
                ];
            })->toArray();
        }
        // dd($this->cartItems);
    }

    protected function loadShippingMethods()
    {
        $this->shippingMethods = ShippingMethod::all()->map(function ($method) {
            return [
                'id' => $method->id,
                'name' => $method->name,
                'cost' => $method->cost,
            ];
        })->toArray();

        $this->selectedShippingMethod = $this->shippingMethods[0]['id'] ?? null;
    }

    public function calculateTotalPrice()
    {
        $cartTotal = array_sum(array_column($this->cartItems, 'total_price'));
        $shippingCost = ShippingMethod::find($this->selectedShippingMethod)->cost ?? 0;
        $this->totalPrice = $cartTotal + $shippingCost;
    }

    public function updatedSelectedShippingMethod()
    {
        $this->calculateTotalPrice();
    }

    public function applyCoupon()
    {
        $coupon = Coupon::where('code', $this->couponCode)->first();
        if (!$coupon || $coupon->isExpired()) {
            $this->couponError = 'Invalid or expired coupon.';
            $this->couponSuccess = '';
            return;
        }

        $discount = $coupon->getDiscount($this->totalPrice);
        $this->totalPrice -= $discount;
        $this->couponSuccess = 'Coupon applied successfully!';
        $this->couponError = '';
    }

    public function proceedToPayment()
    {
        $paymentData = [
            'customer_name' => Auth::user()->first_name,
            'currency_iso' => 'KWD',
            'mobile_country_code' => '+965',
            'customer_mobile' => Auth::user()->phone ?? '',
            'customer_email' => Auth::user()->email ?? '',
            'invoice_value' => $this->totalPrice,
            'payment_method_id' => $this->selectedShippingMethod,
            'coupon_code' => $this->couponCode,
        ];
        // dd($paymentData['invoice_value'], $paymentData['currency_iso']);
        return $this->initiatePayment($paymentData);
    }

    public function initiatePayment(array $paymentData)
    {
        try {
            $paymentResponse = $this->myfatoorahService->initiatePayment($paymentData['invoice_value'], $paymentData['currency_iso']);
            return redirect()->away($paymentResponse['PaymentURL']);
        } catch (\Exception $e) {
            session()->flash('error', 'Payment initiation failed. Please try again.');
            return back();
        }
    }

    public function paymentSuccess()
    {
        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'completed',
                'total_price' => $this->totalPrice,
            ]);

            CartItem::where('cart_id', Cart::where('user_id', Auth::id())->first()->id)->delete();
            DB::commit();

            return redirect()->route('order.confirmation', ['order' => $order->id])
                ->with('success', 'Payment successful. Thank you for your order!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to complete the payment. Please try again.');
            return back();
        }
    }

    public function paymentError()
    {
        return redirect()->route('cart.view')->with('error', 'Payment failed. Please try again.');
    }

    public function render()
    {
        return view('livewire.checkout')
            ->extends('layout.app')
            ->section('content');
    }
}
