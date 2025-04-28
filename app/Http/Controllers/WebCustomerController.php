<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use App\Http\Requests\CreateOrUpdateCustomerRequest;

class WebCustomerController extends Controller
{
    public function createOrUpdateCustomer(CreateOrUpdateCustomerRequest $request)
    {

        $id = Redis::get('national_id_' . $request->national_id);

        if ($id) {
            // Update the existing customer
            $customer = Customer::where('id', $id)->update($request->validated());

            info("line " . __LINE__ . " Customer update");

            return response()->json([
                'message' => 'Customer updated successfully',
                'data' => $customer,
            ], 200);
        } else {
            // Create a new customer

            $customer = Customer::create($request->validated());

            info("line " . __LINE__ . " Customer creation");


            return response()->json([
                'message' => 'Customer created successfully',
                'data' => $customer,
            ], 201);
        }
    }
    public function createOrUpdateCustomerUsingCache(CreateOrUpdateCustomerRequest $request)
    {
        $id = Cache::get('national_id_' . $request->national_id);

        if ($id) {
            // Update the existing customer
            $customer = Customer::where('id', $id)->update($request->validated());

            // info("line " . __LINE__ . " Customer update");

            return response()->json([
                'message' => 'Customer updated successfully',
                'data' => $customer,
            ], 200);
        } else {
            // Create a new customer

            $customer = Customer::create($request->validated());

            // info("line " . __LINE__ . " Customer creation");


            return response()->json([
                'message' => 'Customer created successfully',
                'data' => $customer,
            ], 201);
        }
    }
    public function create(CreateOrUpdateCustomerRequest $request)
    {

        // Update the existing customer
        $customer = Customer::where('national_id', $request->national_id)->first();
        if ($customer) {
            $customer->update($request->validated());
            // info("line " . __LINE__ . " Customer update");

            return response()->json([
                'message' => 'Customer updated successfully',
                'data' => $customer,
            ], 200);
        } else {
            // Create a new customer

            $customer = Customer::create($request->validated());

            // info("line " . __LINE__ . " Customer creation");


            return response()->json([
                'message' => 'Customer created successfully',
                'data' => $customer,
            ], 201);
        }
    }


    public function getCustomersUsingCache()
    {
        // Fetch all customers to get their national IDs
        $customers = Customer::select('national_id')->get();

        if ($customers->isEmpty()) {
            info('No customers found in the database.');
            return;
        }

        // Iterate through customers and retrieve cached data
        foreach ($customers as $customer) {
            $cachedId = Cache::get('national_id_' . $customer->national_id);

            if ($cachedId) {
                info("National ID: {$customer->national_id}, Cached Customer ID: {$cachedId}");
            } else {
                info("No cached data found for National ID: {$customer->national_id}");
            }
        }
    }
}
