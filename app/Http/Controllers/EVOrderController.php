<?php

namespace App\Http\Controllers;

use App\Facades\MyShop;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class EVOrderController extends Controller
{
    public function index()
    {

        if(!\Permissions::canAccess(User::$non_customer_user_types, ['all_orders', 'browse_orders'], false)) {
            return redirect()->route('my.orders.all');
        }

        $orders_count = MyShop::getShop()->orders()->count(); // Reminder: there is a global scope to add shop_id

        return view('frontend.dashboard.orders.index', compact('orders_count'));
    }

    public function create()
    {
        return view('frontend.dashboard.orders.create');
    }

    public function details(Request $request, $order_id)
    {
        $order = Order::findOrFail($order_id);
        $order_items = $order->order_items()->with(['subject'])->get();
        $user = $order->user;

        // If order was not viewed, mark it as viewed!
        if (! $order->viewed) {
            $order->viewed = true;
            $order->save();
        }

        return view('frontend.dashboard.orders.details', compact('order', 'order_items', 'user'));
    }

    public function my_purchases(Request $request)
    {
        $ownerships = auth()->user()->owned_assets()->orderBy('created_at', 'desc')->paginate(20);
        $ownerships_count_all = auth()->user()->owned_assets()->count();

        return view('frontend.dashboard.my-purchases.index', compact('ownerships', 'ownerships_count_all'));
    }

    public function my_orders(Request $request)
    {
        $orders = auth()->user()->orders()->orderBy('created_at', 'desc')->paginate(20);
        $orders_count = auth()->user()->orders()->count();

        return view('frontend.dashboard.my-orders.index', compact('orders', 'orders_count'));
    }
}
