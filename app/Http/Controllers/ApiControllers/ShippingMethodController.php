<?php

namespace App\Http\Controllers\ApiControllers;

use App\Models\Order;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShippingMethodResource;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class ShippingMethodController extends Controller
{
    /**
     * Display a listing of the shipping methods.
     */
    public function index()
    {
        $shippingMethods = ShippingMethod::all();

        // Return the collection of shipping methods as a resource
        return response()->json(["shippingMethods" => $shippingMethods], Response::HTTP_OK);
    }

    /**
     * Store the selected shipping method for an order.
     */
    public function store(Request $request, $orderId): Response
    {
        // Validate the request
        $request->validate([
            'shipping_method_id' => 'required|exists:shipping_methods,id',
        ]);

        $order = Order::findOrFail($orderId);
        $order->shipping_method_id = $request->shipping_method_id;
        $order->save();

        // Return success response with HTTP status
        return response()->json([
            'message' => 'Shipping method updated.',
            'order' => $order
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified shipping method.
     */
    public function show($id): Response
    {
        $shippingMethod = ShippingMethod::findOrFail($id);

        // Return single shipping method resource
        return response()->json(new ShippingMethodResource($shippingMethod), Response::HTTP_OK);
    }

    /**
     * Update the specified shipping method.
     */
    public function update(Request $request, $id): Response
    {
        $shippingMethod = ShippingMethod::findOrFail($id);

        // Validate the request
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'cost' => 'sometimes|required|numeric',
            'delivery_time' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'is_active' => 'sometimes|required|boolean',
            'is_free' => 'sometimes|required|boolean',
        ]);

        $shippingMethod->update($request->only([
            'name',
            'cost',
            'delivery_time',
            'description',
            'is_active',
            'is_free'
        ]));

        // Return success response
        return response()->json([
            'message' => 'Shipping method updated successfully.',
            'shipping_method' => $shippingMethod
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified shipping method from storage.
     */
    public function destroy($id): Response
    {
        $shippingMethod = ShippingMethod::findOrFail($id);
        $shippingMethod->delete();

        return response()->json([
            'message' => 'Shipping method deleted successfully.'
        ], Response::HTTP_NO_CONTENT);
    }
}
