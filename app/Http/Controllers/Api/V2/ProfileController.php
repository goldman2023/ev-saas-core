<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\City;
use App\Models\Country;
use App\Http\Resources\V2\AddressCollection;
use App\Models\Address;
use App\Http\Resources\V2\CitiesCollection;
use App\Http\Resources\V2\CountriesCollection;
use App\Models\Order;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Models\Cart;

class ProfileController extends Controller
{
    public function counters($user_id)
    {
        return response()->json([
            'cart_item_count' => Cart::where('user_id', $user_id)->count(),
            'wishlist_item_count' => Wishlist::where('user_id', $user_id)->count(),
            'order_count' => Order::where('user_id', $user_id)->count(),
        ]);
    }
}
