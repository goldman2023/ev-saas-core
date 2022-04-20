<?php

namespace App\Http\Controllers;

use App\Models\Central\User;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class EVWishlistController extends Controller
{
    //
    public $availableWishlistItems = [
        'App\Models\Product' => 'Product',
        // 'App\Models\Shop' => 'Shop',
    ];

    public $wishlists;

    public function index()
    {
        foreach ($this->availableWishlistItems as $key => $type) {
            if (auth()->user()) {
                $this->wishlists[$type] = Wishlist::where('user_id', auth()->user()->id)
                    ->where('subject_type', $key)
                    ->get();
            } else {
                $session_id = session()->getId();
                $this->wishlists[$type] = Wishlist::where('session_id', $session_id)
                    ->where('subject_type', $key)
                    ->get();
            }

            if ($this->wishlists[$type] === null) {
                $this->wishlists[$type] = collect([]);
            }
        }

        return view('frontend.wishlist.index', [
            'wishlists' => $this->wishlists,
        ]);
    }

    public function views()
    {
        if (auth()->user()) {
            $products = auth()->user()->recently_viewed_products();
        } else {
            /* TODO: If user is guest save product's in session storage */
            $products = collect([]);
        }

        return view('frontend.wishlist.views', compact('products'));
    }
}
