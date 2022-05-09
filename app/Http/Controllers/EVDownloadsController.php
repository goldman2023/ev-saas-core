<?php

namespace App\Http\Controllers;

use App\Facades\MyShop;
use App\Models\Order;
use Illuminate\Http\Request;

class EVDownloadsController extends Controller
{
    public function my_downloads(Request $request)
    {
        // $orders = auth()->user()->orders()->orderBy('created_at', 'desc')->paginate(20);
        // $orders_count = auth()->user()->orders()->count();

        return view('frontend.dashboard.my-downloads.index');
    }
}
