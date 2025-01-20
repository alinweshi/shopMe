<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Show the order confirmation page.
     */
    public function confirmation($orderId)
    {
        // Retrieve the order along with its items
        $order = Order::with('items.product')->findOrFail($orderId);
        return view('backend.order.confirmation', data: ['order' => $order]);
    }

    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10); // Adjust the number per page as needed
        return view('backend.order.index', ['orders' => $orders]);
    }

    public function updateStatus(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->status = $request->input('status');
        $order->save();
        return redirect()->route(route: 'orders.index')->with('success', 'Order status updated.');
    }

    public function show($orderId)
    {
        $order = Order::with('items.product', 'user')->findOrFail($orderId);
        return view('backend.order.show', ['order' => $order]);
    }

    public function edit($orderId)
    {
        // Retrieve the order for editing
        $order = Order::findOrFail($orderId);
        return view('backend.order.edit', ['order' => $order]);
    }

    public function createOrder(Request $request)
    {
        // Validate the request data if necessary
        $request->validate([
            'shipping_address' => 'required|string',
            'billing_address' => 'required|string',
            // Add other validation rules as needed
        ]);

        // Retrieve the cart for the authenticated user
        $cart = Cart::where('user_id', Auth::id())->firstOrFail();

        // Create a new order
        $order = new Order();
        $order->user_id = Auth::id();
        $order->total_price = $cart->getTotalWithDiscount(); // Assuming this method calculates the total with discounts

        // If there's a coupon applied to the cart, set the coupon data in the order
        if ($cart->coupon) {
            $order->coupon_id = $cart->coupon->id; // Store coupon ID in the order
            $order->discount = $cart->calculateDiscount($cart->total_price); // Calculate the discount
        }

        // Calculate tax and save the order with tax details
        $order->saveOrderWithTax(); // Call the new method to save tax details

        // Move cart items to order items
        foreach ($cart->items as $cartItem) {
            $order->items()->create([
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->price,
                'total_price' => $cartItem->total_price,
            ]);
        }

        // Optionally: Clear the cart after creating the order
        $cart->clear(); // Assuming there's a method to clear the cart

        // Redirect or return a response
        return redirect()->route('orders.confirmation', ['orderId' => $order->id])
            ->with('success', 'Your order has been created successfully!');
    }
}
