<?php

namespace App\Http\Controllers;

use App\Facades\MyShop;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class WeInvoiceController extends Controller
{
    public function index()
    {
        if(!\Permissions::canAccess(User::$non_customer_user_types, ['all_orders', 'browse_orders'], false)) {
            return redirect()->route('my.orders.all');
        }

        $invoices_count = MyShop::getShop()->invoices()->count(); // Reminder: there is a global scope to add shop_id

        return view('frontend.dashboard.invoices.index', compact('invoices_count'));
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

    public function download_invoice(Request $request, $id) {
        try {
            $invoice = Invoice::findOrFail($id);
            // TODO: Move access restrictions to some Policy classes!!!!
            if($invoice->user_id === auth()->user()->id || $invoice->shop_id === \MyShop::getShopID() || auth()->user()->isAdmin()) {
                return $invoice->generateInvoicePDF();
            }

            throw new \Exception();
        } catch(\Exception $e) {
            dd($e);
            abort(404);
        }
    }

    public function download_upcoming_invoice(Request $request, $order_id) {
        $order = Order::findOrFail($order_id);

        if($order->user_id === auth()->user()->id || $order->shop_id === \MyShop::getShopID() || auth()->user()->isAdmin()) {
            $last_invoice = $order->invoices()->withoutGlobalScopes()->orderBy('created_at', 'desc')->first();

            if(!empty($last_invoice)) {
                $stripe_upcoming_invoice = $order->user_subscription->getUpcomingInvoiceStats();
                $upcoming_invoice = clone $last_invoice;
                $upcoming_invoice->setData(stripe_prefix('stripe_invoice_data'), $stripe_upcoming_invoice); // replace stripe_invoice_data meta property with upcoming_invoice
                $upcoming_invoice->id = null;
                $upcoming_invoice->invoice_number = 'invoice-draft';
                $upcoming_invoice->payment_status = 'upcoming';
                $upcoming_invoice->start_date = '';
                $upcoming_invoice->end_date = '';
                $upcoming_invoice->real_invoice_number = null;
                $upcoming_invoice->real_invoice_prefix = 'AA';
                $upcoming_invoice->created_at = \Carbon::createFromTimestamp($stripe_upcoming_invoice['created']);

                return $upcoming_invoice->generateInvoicePDF(custom_title: translate('UPCOMING VAT INVOICE'));
            }
        }

        abort(404);
    }
}
