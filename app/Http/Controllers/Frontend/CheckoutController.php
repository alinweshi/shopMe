<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\MyFatoorahService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CheckoutController extends Controller
{
    private $myfatoorahService;

    public function __construct(MyFatoorahService $myfatoorahService)
    {
        $this->myfatoorahService = $myfatoorahService;
    }

    /**
     * Show the checkout page.
     */
    public function index()
    {
        $user = auth()->user();
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('checkout.index', ['cartItems' => $cartItems]);
    }

    /**
     * Process the checkout and redirect to payment gateway.
     */
    public function process(Request $request)
    {
        $user = auth()->user();
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            // Create the order
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $cartItems->sum('total_price'),
                'status' => 'pending',
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total_price' => $item->total_price,
                ]);
            }

            DB::commit();

            // Prepare payment request
            $paymentData = [
                'amount' => $order->total_price,
                'currency' => 'USD',
                'order_id' => $order->id,
                'return_url' => route('payment.success'),
                'error_url' => route(name: 'payment.error'),
            ];

            $response = $this->myfatoorahService->sendPayment($paymentData);

            // Redirect to the payment gateway
            return Redirect::away($response->PaymentURL);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Failed to process your order. Please try again.');
        }
    }

    /**
     * Handle payment success.
     */
    public function paymentSuccess(Request $request)
    {
        $orderId = $request->input('order_id');
        $order = Order::findOrFail($orderId);

        DB::beginTransaction();

        try {
            $order->status = 'completed';
            $order->save();

            // Clear the cart
            Cart::where('user_id', auth()->user()->id)->delete();

            DB::commit();

            return redirect()->route('order.confirmation', ['order' => $orderId])
                ->with('success', 'Payment successful. Thank you for your order!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Failed to complete the payment. Please try again.');
        }
    }

    /**
     * Handle payment error.
     */
    public function paymentError(Request $request)
    {
        return redirect()->route('cart.index')
            ->with('error', 'Payment failed. Please try again.');
    }
}
