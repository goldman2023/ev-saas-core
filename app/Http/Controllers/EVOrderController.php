<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Facades\MyShop;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function create($customerID = null)
    {
        if($customerID) {
            $customer = User::find($customerID);
        } else {
            $customer = null;
        }

        return view('frontend.dashboard.orders.create', compact('customer'));
    }

    public function edit(Request $request, $order_id)
    {
        $order = Order::findOrFail($order_id);

        return view('frontend.dashboard.orders.edit', compact('order'));
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

    public function change_status($order_id) {
        $order = Order::findOrFail($order_id);

        if(is_integer($order->status)) {
            // dd($order->status);
            $order->status = $order->status + 1;
        } else {
            $order->status = 1;
        }


        $reason = '';
        if($order->status == 1) {
            $reason = translate('Order Created');
        } else if($order->status == 2) {
            $reason = translate('Contract Signed');
        } else if($order->status == 3) {
            $reason = translate('Approved for manufacturing');
        }
        // $order->setStatus('status-' .  $order->status, $reason);

        $order->save();

        do_action('order.change-status', $order);

        activity()
        ->performedOn($order)
        ->causedBy(auth()->user())
        ->withProperties([
            'action' => 'changed_status',
            'action_title' => 'Changed status to: ' . $order->status,
        ])
        ->log('Updated order status to: ' . OrderStatusEnum::labels()[$order->status]);

        session()->flash('message', translate('Order status updated'));




        return redirect()->back();
    }



}
