<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * Show the order confirmation page.
     */
    public function confirmation($orderId)
    {
        // Retrieve the order along with its items
        $order = Order::with('items.product')->findOrFail($orderId);

        return view('order.confirmation', data: ['order' => $order]);
    }
    public function index()
    {
        $orders = Order::with(relations: 'user')->latest()->get(); // Retrieve all orders with user information

        return view('order.index', ['orders' => $orders]);
    }
    public function updateStatus(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->status = $request->input('status');
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Order status updated.');
    }
    public function show($orderId)
    {
        $order = Order::with('items.product', 'user')->findOrFail($orderId);

        return view('order.show', ['order' => $order]);
    }

}
