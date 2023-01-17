<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class QuotesController extends Controller
{
    public function create()
    {
        $quote = new Order();
        $quote->shop_id = 1;
        $quote->user_id = auth()?->user()?->id ?? null;


        return view('frontend.request-quote', compact('quote'));
    }
}
