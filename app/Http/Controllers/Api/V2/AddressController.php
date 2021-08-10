<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\City;
use App\Models\Country;
use App\Http\Resources\V2\AddressCollection;
use App\Models\Address;
use App\Http\Resources\V2\CitiesCollection;
use App\Http\Resources\V2\CountriesCollection;
use Illuminate\Http\Request;
use App\Models\Cart;

class AddressController extends Controller
{
    public function addresses($id)
    {
        return new AddressCollection(Address::where('user_id', $id)->get());
    }

    public function createShippingAddress(Request $request)
    {
        $address = new Address;
        $address->user_id = $request->user_id;
        $address->address = $request->address;
        $address->country = $request->country;
        $address->city = $request->city;
        $address->postal_code = $request->postal_code;
        $address->phone = $request->phone;
        $address->save();

        return response()->json([
            'result' => true,
            'message' => 'Shipping information has been added successfully'
        ]);
    }

    public function deleteShippingAddress($id)
    {
        $address = Address::findOrFail($id);
        $address->delete();
        return response()->json([
            'result' => true,
            'message' => 'Shipping information has been added deleted'
        ]);
    }

    public function updateAddressInCart(Request $request)
    {
        try {
            Cart::where('user_id', $request->user_id)->update(['address_id' => $request->address_id]);

        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => 'Could not save the address'
            ]);
        }
        return response()->json([
            'result' => true,
            'message' => 'Address is saved'
        ]);


    }

    public function getCities()
    {
        return new CitiesCollection(City::all());
    }

    public function getCountries()
    {
        return new CountriesCollection(Country::where('status', 1)->get());
    }
}
