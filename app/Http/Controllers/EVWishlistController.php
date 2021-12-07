<?php

namespace App\Http\Controllers;

use App\Models\Central\User;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class EVWishlistController extends Controller
{
    //

    public function index()
    {
        if(auth()->user()) {
            $products = User::find(auth()->user()->id)->wishlist;
        } else {
            $session_id = session()->getId();
            $products = Wishlist::where('session_id', $session_id)->get();
        }



        return view('frontend.wishlist.index', compact('products'));
    }
}
