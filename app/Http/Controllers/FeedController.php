<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class FeedController extends Controller
{
    //
    public function index() {
        return view('frontend.feed.index');
    }

    public function shops() {
        $shops = Shop::all();
        $users = Shop::orderBy('created_at', 'desc')->all();

        return view('frontend.feed.shops', compact(['shops', 'users']));
    }

    public function products() {
        $products = Product::orderBy('created_at', 'desc')->all();
        return view('frontend.feed.products', compact('products'));
    }
}
