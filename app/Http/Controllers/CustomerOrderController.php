<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerOrder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Barryvdh\Debugbar\Facades\Debugbar;

class CustomerOrderController extends Controller
{
    public function indexRedis()
    {
        if (Redis::exists('orders')) {
            $orders = json_decode(Redis::get('orders'), true);
            return response()->json([
                'message' => 'cached from Redis',
                'data' => $orders
            ]);
        } else {
            $orders = CustomerOrder::all();
            // Redis::set('orders', json_encode($orders))->expire('orders', 60);
            Redis::set('orders', json_encode($orders), 'EX', 60);

            return response()->json([
                'message' => 'cached from database',
                'data' => $orders
            ]);
        }
    }

    public function indexCache()
    {
        $start = microtime(true);
        $orders = Cache::get('orders');
        if ($orders) {
            Log::info('Cache fetch time: ' . (microtime(true) - $start) . ' seconds');
            return response()->json([
                'message' => 'cached from Cache',
                'data' => $orders
            ]);
        } else {
            $orders = CustomerOrder::all();
            Cache::put('orders', $orders, 60);
            Log::info('Database fetch and Cache store time: ' . (microtime(true) - $start) . ' seconds');
            return response()->json([
                'message' => 'cached from Database',
                'data' => $orders
            ]);
        }
    }
    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'orderNumber' => 'required|integer',
            'orderDate' => 'required|date',
            'requiredDate' => 'required|date',
            'shippedDate' => 'nullable|date',
            'status' => 'required|string|max:15',
            'comments' => 'nullable|string',
            'customerNumber' => 'required|integer',
        ]);

        CustomerOrder::create($validatedData);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(CustomerOrder $order)
    {
        return view('orders.show', compact('order'));
    }

    public function edit(CustomerOrder $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, CustomerOrder $order)
    {
        $validatedData = $request->validate([
            'orderDate' => 'required|date',
            'requiredDate' => 'required|date',
            'shippedDate' => 'nullable|date',
            'status' => 'required|string|max:15',
            'comments' => 'nullable|string',
            'customerNumber' => 'required|integer',
        ]);

        $order->update($validatedData);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(CustomerOrder $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
