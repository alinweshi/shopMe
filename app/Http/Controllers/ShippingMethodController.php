<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class ShippingMethodController extends Controller
{
    /**
     * Display a listing of the shipping methods.
     */
    public function index()
    {
        $shippingMethods = ShippingMethod::all();
        return view('shipping.index', compact('shippingMethods'));
    }

    /**
     * Store the selected shipping method for an order.
     */
    public function store(Request $request, $orderId)
    {
        $request->validate([
            'shipping_method_id' => 'required|exists:shipping_methods,id',
        ]);

        $order = Order::findOrFail($orderId);
        $order->shipping_method_id = $request->shipping_method_id;
        $order->save();

        return redirect()->route('checkout.index')->with('success', 'Shipping method updated.');
    }

    /**
     * Display a listing of the resource.
     */

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(ShippingMethod $shippingMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingMethod $shippingMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShippingMethod $shippingMethod)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingMethod $shippingMethod)
    {
        //
    }
}
