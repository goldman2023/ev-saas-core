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
            $products = Wishlist::where('user_id', auth()->user()->id)->get();
        } else {
            $session_id = session()->getId();
            $products = Wishlist::where('session_id', $session_id)->get();
        }

        if($products === null) {
            $products = collect([]);
        }




        return view('frontend.wishlist.index', compact('products'));
    }

    public function views() {
        if(auth()->user()){
            $products = auth()->user()->recently_viewed_products();
        } else {
            /* TODO: If user is guest save product's in session storage */
            $products = collect([]);
        }

        return view('frontend.wishlist.views', compact('products'));
    }
}
