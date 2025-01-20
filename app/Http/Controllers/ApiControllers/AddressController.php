<?php

namespace App\Http\Controllers\ApiControllers;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddNewAddressRequest;

class AddressController extends Controller
{
    public function addNewAddress(AddNewAddressRequest $request)
    {
        $userId = Auth::user()->id;
        $user = User::find($userId);
        $addressId = $user->addresses();
        // dd($addressId);
        if (Auth::check()) {
            try {
                $user = Auth::user();
                $address = Address::where('user_id', $user->id)->first();
                $address->update(attributes: [
                    'user_id' => $user->id,
                    'line1' => $request->line1,
                    'line2' => $request->line2,
                    'city' => $request->city,
                    'country' => $request->country,
                    'postal_code' => $request->postal_code,
                ]);
                $address->save();
                // dd($address);

                return response()->json([
                    'success' => true,
                    'address' => $address,
                ], 201);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage(),
                ], 500);
            }
        }
    }
}
