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
        // $users = Users::all();

        return view('frontend.feed.shops', compact(['shops']));
    }

    public function products() {
        $products = Product::all();
        return view('frontend.feed.products', compact('products'));
    }
}
