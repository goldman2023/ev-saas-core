<?php

namespace App\Http\Controllers;

use App\Facades\MyShop;
use App\Models\Order;
use Illuminate\Http\Request;

class EVOrderController extends Controller
{
    public function index() {
        $orders = MyShop::getShop()->orders()->orderBy('created_at','desc')->paginate(20);
        $orders_count = MyShop::getShop()->orders()->count();

        return view('frontend.dashboard.orders.index',  compact('orders','orders_count'));
    }

    public function details(Request $request, $order_id) {
        $order = Order::find($order_id);
        $order_items = $order->order_items;
        $user = $order->user;

        return view('frontend.dashboard.orders.details',  compact('order', 'order_items', 'user'));
    }

    public function my_purchases(Request $request) {
        $orders = auth()->user()->orders()->orderBy('created_at','desc')->paginate(20);
        $orders_count = auth()->user()->orders()->count();

        return view('frontend.dashboard.my-purchases.index',  compact('orders','orders_count'));
    }
}
