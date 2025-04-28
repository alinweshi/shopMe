<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\CreateOrUpdateCustomerRequest;

class CustomerController extends Controller
{

    public function createOrUpdateCustomer(CreateOrUpdateCustomerRequest $request)
    {
        $customer = Customer::where($request->national_id)->first();
        if ($customer) {
            $customer->update($request->validated());
            return response()->json($customer, 200);
        } else {
            $customer = Customer::create($request->all());
            return response()->json($customer, 201);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index() {}

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
