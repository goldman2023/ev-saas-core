<?php

namespace App\Http\Controllers;

use App\Facades\MyShop;
use App\Models\Order;
use Illuminate\Http\Request;

class EVOrderController extends Controller
{
    public function index() {
//        $orders = MyShop::getShop()->orders()->orderBy('created_at','desc')->paginate(20);
        // ^^^ $orders will be queried in livewire datatable component ^^^^
        // $orders = Order::query()->where('shop_id', MyShop::getShopID());
        $orders_count = Order::count(); // Reminder: there is a global scope to add shop_id

        return view('frontend.dashboard.orders.index',  compact('orders_count'));
    }

    public function create() {
        return view('frontend.dashboard.orders.create');
    }

    public function details(Request $request, $order_id) {
        $order = Order::findOrFail($order_id);
        $order_items = $order->order_items;
        $user = $order->user;

        // If order was not viewed, mark it as viewed!
        if(!$order->viewed) {
            $order->viewed = true;
            $order->save();
        }

        return view('frontend.dashboard.orders.details',  compact('order', 'order_items', 'user'));
    }

    public function my_purchases(Request $request) {
        $orders = auth()->user()->orders()->orderBy('created_at','desc')->paginate(20);
        $orders_count = auth()->user()->orders()->count();

        return view('frontend.dashboard.my-purchases.index',  compact('orders','orders_count'));
    }
}
