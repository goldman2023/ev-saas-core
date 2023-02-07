<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class FeedController extends Controller
{
    //
    public function __construct()
    {

    }
    public function index()
    {
        $this->middleware('auth');
        if(get_tenant_setting('feed_enabled', true) == false) {
            return redirect()->route('home');
        }

        $type = "index";

        return view('frontend.feed.index');
    }

    public function trending()
    {
        $feed_type = "trending";
        return view('frontend.feed.index', compact('feed_type'));
    }

    public function discussions()
    {
        $feed_type = "trending"; //"discussions";
        return view('frontend.feed.index', compact('feed_type'));
    }

    public function bookmarks()
    {
        $type = "bookmarks";
        return view('frontend.feed.index');
    }

    public function shops()
    {
        $shops = Shop::whereHas('products')->paginate(50);
        // $users = Users::all();

        return view('frontend.feed.shops', compact(['shops']));
    }

    public function products()
    {
        $products = Product::where('status', 'published')->paginate(50);

        return view('frontend.feed.products', compact('products'));
    }

    public function courses()
    {
        $products = Product::where('status', 'published')->where('type', '=' ,'course')->paginate(50);

        return view('frontend.feed.products', compact('products'));
    }
}
