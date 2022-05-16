<?php

namespace App\Http\Controllers;

use App\Facades\MyShop;
use App\Models\Order;
use Illuminate\Http\Request;

class EVDownloadsController extends Controller
{
    public function my_downloads(Request $request)
    {
        // $orders = auth()->user()->orders()->orderBy('created_at', 'desc')->with()
        // $orders_count = auth()->user()->orders()->count();

        // dd(auth()->user()->purchasedProducts());
        return view('frontend.dashboard.my-downloads.index');
    }
}
