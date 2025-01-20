<?php
namespace App\Http\Controllers\frontend;


use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiOrderController extends Controller
{
    /**
     * Retrieve order details for confirmation.
     */
    public function confirmation($orderId)
    {
        $order = Order::with('items.product')->find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found.'], 404);
        }

        return response()->json([
            'message' => 'Order retrieved successfully.',
            'order' => $order,
        ]);
    }

    /**
     * Get a paginated list of orders.
     */
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);

        return response()->json([
            'message' => 'Orders retrieved successfully.',
            'orders' => $orders,
        ]);
    }

    /**
     * Update the status of an order.
     */
    public function updateStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found.'], 404);
        }

        $order->status = $request->input('status');
        $order->save();

        return response()->json([
            'message' => 'Order status updated successfully.',
            'order' => $order,
        ]);
    }

    /**
     * Retrieve a specific order.
     */
    public function show($orderId)
    {
        $order = Order::with('items.product', 'user')->find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found.'], 404);
        }

        return response()->json([
            'message' => 'Order retrieved successfully.',
            'order' => $order,
        ]);
    }

    /**
     * Create a new order.
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'billing_address' => 'required|string',
        ]);

        // Retrieve the cart for the authenticated user
        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['error' => 'Cart is empty or not found.'], 400);
        }

        // Create a new order
        $order = new Order();
        $order->user_id = Auth::id();
        $order->shipping_address = $request->input('shipping_address');
        $order->billing_address = $request->input('billing_address');
        $order->total_price = $cart->getTotalWithDiscount();

        // Apply coupon if present
        if ($cart->coupon) {
            $order->coupon_id = $cart->coupon->id;
            $order->discount = $cart->calculateDiscount($cart->total_price);
        }

        // Save the order with tax details
        $order->saveOrderWithTax();

        // Move cart items to order items
        foreach ($cart->items as $cartItem) {
            $order->items()->create([
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'unit_price' => $cartItem->price,
                'total_price' => $cartItem->total_price,
            ]);
        }

        // Clear the cart after creating the order
        $cart->clear();

        return response()->json([
            'message' => 'Order created successfully.',
            'order' => $order,
        ]);
    }
}
