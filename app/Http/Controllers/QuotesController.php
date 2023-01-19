<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class QuotesController extends Controller
{
    public function create()
    {
        $quote = new Order();
        $quote->shop_id = 1;
        $quote->user_id = auth()?->user()?->id ?? null;


        return view('frontend.request-quote', compact('quote'));
    }

    public function quoteReceived($order_id) {
        $order = Order::find($order_id);

        /* Used for /order/demo/received demo */
        if($order_id == 'demo') {
            $order = Order::find(2);
        }

        /**
         * Order Received page (or Thank you page) can be accessed only by user who bought it.
         * But what are we going to do with Guest users?
         * 1. They will be identified by session ID
         * 2. Email will be sent to them to finalize registration (when ghost/guest user is created in our DB after purchase)
        */
        $ghost_user = User::where('session_id', Session::getId())->first();

        if($order_id != 'demo') {
            if(!Auth::check() && $order->user_id !== ($ghost_user?->id ?? null)) {
                // Guest users - identify them by session_id and check if any user has that session_id, if not redirect!
                return redirect()->route('user.login');
            } else if(Auth::check() && $order->user_id !== (auth()->user()?->id ?? null) && !auth()->user()->isAdmin()) {
                return redirect()->route('home');
            }
        }

        return view('frontend.quote-received', compact('order', 'ghost_user'));

    }
}
