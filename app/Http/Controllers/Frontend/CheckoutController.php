<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\ShippingMethod;
use Illuminate\Support\Facades\DB;
use App\Services\MyFatoorahService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $myfatoorahService;

    public function __construct(MyFatoorahService $myfatoorahService)
    {
        $this->myfatoorahService = $myfatoorahService;
    }

    public function index()
    {
        $cartItems = $this->loadCartItems();
        $shippingMethods = $this->loadShippingMethods();
        $selectedShippingMethod = $shippingMethods[0]['id'] ?? null;
        $totalPrice = $this->calculateTotalPrice($cartItems, $selectedShippingMethod);

        return view('frontend.checkout.index', compact('cartItems', 'shippingMethods', 'selectedShippingMethod', 'totalPrice'));
    }

    protected function loadCartItems()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)
            ->with(['cartItems.product:id,name,price'])
            ->first();

        if ($cart) {
            return $cart->cartItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->product->name ?? 'Product not available',
                    'quantity' => $item->quantity,
                    'unit_price' => $item->product->price ?? 0,
                    'total_price' => $item->total_price,
                ];
            })->toArray();
        }

        return [];
    }

    protected function loadShippingMethods()
    {
        return ShippingMethod::all()->map(function ($method) {
            return [
                'id' => $method->id,
                'name' => $method->name,
                'cost' => $method->cost,
            ];
        })->toArray();
    }

    protected function calculateTotalPrice($cartItems, $selectedShippingMethod)
    {
        $cartTotal = array_sum(array_column($cartItems, 'total_price'));
        $shippingCost = ShippingMethod::find($selectedShippingMethod)->cost ?? 0;

        return $cartTotal + $shippingCost;
    }

    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');
        $coupon = Coupon::where('code', $couponCode)->first();

        if (!$coupon || $coupon->isExpired()) {
            return back()->withErrors(['coupon' => 'Invalid or expired coupon.']);
        }

        $totalPrice = $this->calculateTotalPrice($this->loadCartItems(), $request->input('selected_shipping_method'));
        $discount = $coupon->getDiscount($totalPrice);

        $totalPrice -= $discount;

        return back()->with(['totalPrice' => $totalPrice, 'couponSuccess' => 'Coupon applied successfully!']);
    }

    public function proceedToPayment(Request $request)
    {
        $paymentData = [
            'customer_name' => Auth::user()->first_name,
            'currency_iso' => 'KWD',
            'mobile_country_code' => '+965',
            'customer_mobile' => Auth::user()->phone ?? '',
            'customer_email' => Auth::user()->email ?? '',
            'invoice_value' => $request->input('total_price'),
            'payment_method_id' => $request->input('selected_shipping_method'),
            'coupon_code' => $request->input('coupon_code'),
        ];

        return $this->initiatePayment($paymentData);
    }

    public function initiatePayment(array $paymentData)
    {
        try {
            $paymentResponse = $this->myfatoorahService->initiatePayment($paymentData['invoice_value'], $paymentData['currency_iso']);
            return redirect()->away($paymentResponse['PaymentURL']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Payment initiation failed. Please try again.']);
        }
    }

    public function paymentSuccess()
    {
        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'completed',
                'total_price' => request('total_price'),
            ]);

            CartItem::where('cart_id', Cart::where('user_id', Auth::id())->first()->id)->delete();
            DB::commit();

            return redirect()->route('order.confirmation', ['order' => $order->id])
                ->with('success', 'Payment successful. Thank you for your order!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to complete the payment. Please try again.']);
        }
    }

    public function paymentError()
    {
        return redirect()->route('cart.view')->withErrors(['error' => 'Payment failed. Please try again.']);
    }
}
