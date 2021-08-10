<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\OTPVerificationController;
use App\Http\Controllers\ClubPointController;
use App\Http\Controllers\AffiliateController;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\CommissionHistory;
use App\Models\Color;
use App\Models\OrderDetail;
use App\Models\CouponUsage;
use App\Models\OtpConfiguration;
use App\Models\User;
use App\Models\BusinessSetting;
use Auth;
use Session;
use DB;
use Mail;
use App\Mail\InvoiceEmailManager;
use CoreComponentRepository;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource to seller.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $orders = DB::table('orders')
                    ->orderBy('code', 'desc')
//                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->where('seller_id', auth()->user()->id)
                    ->select('orders.id')
                    ->distinct();

        if ($request->payment_status != null){
            $orders = $orders->where('payment_status', $request->payment_status);
            $payment_status = $request->payment_status;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')){
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%'.$sort_search.'%');
        }

        $orders = $orders->paginate(15);

        foreach ($orders as $key => $value) {
            $order = \App\Models\Order::find($value->id);
            $order->viewed = 1;
            $order->save();
        }

        return view('frontend.user.seller.orders', compact('orders','payment_status','delivery_status', 'sort_search'));
    }

    // All Orders
    public function all_orders(Request $request)
    {
//         CoreComponentRepository::instantiateShopRepository();

         $date = $request->date;
         $sort_search = null;
         $orders = Order::orderBy('code', 'desc');
         if ($request->has('search')){
             $sort_search = $request->search;
             $orders = $orders->where('code', 'like', '%'.$sort_search.'%');
         }
         if ($date != null) {
             $orders = $orders->where('created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->where('created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
         }
         $orders = $orders->paginate(15);
         return view('backend.sales.all_orders.index', compact('orders', 'sort_search', 'date'));
    }

    public function all_orders_show($id)
    {
         $order = Order::findOrFail($id);
         return view('backend.sales.all_orders.show', compact('order'));
    }

    // Inhouse Orders
    public function admin_orders(Request $request)
    {
//        CoreComponentRepository::instantiateShopRepository();

        $date = $request->date;
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $admin_user_id = User::where('user_type', 'admin')->first()->id;
        $orders = DB::table('orders')
                    ->orderBy('code', 'desc')
//                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->where('seller_id', $admin_user_id)
                    ->select('orders.id')
                    ->distinct();

        if ($request->payment_type != null){
            $orders = $orders->where('payment_status', $request->payment_type);
            $payment_status = $request->payment_type;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')){
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%'.$sort_search.'%');
        }
        if ($date != null) {
            $orders = $orders->whereDate('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }

        $orders = $orders->paginate(15);
        return view('backend.sales.inhouse_orders.index', compact('orders','payment_status','delivery_status', 'sort_search', 'admin_user_id', 'date'));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        $order->viewed = 1;
        $order->save();
        return view('backend.sales.inhouse_orders.show', compact('order'));
    }

    // Seller Orders
    public function seller_orders(Request $request)
    {
        // CoreComponentRepository::instantiateShopRepository();

        $date = $request->date;
        $seller_id = $request->seller_id;
        $payment_status = null;
        $delivery_status = null;
        $sort_search = null;
        $admin_user_id = User::where('user_type', 'admin')->first()->id;
        $orders = DB::table('orders')
                    ->orderBy('code', 'desc')
//                    ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                    ->where('orders.seller_id', '!=' ,$admin_user_id)
                    ->select('orders.id')
                    ->distinct();

        if ($request->payment_type != null){
            $orders = $orders->where('orders.payment_status', $request->payment_type);
            $payment_status = $request->payment_type;
        }
        if ($request->delivery_status != null) {
            $orders = $orders->where('delivery_status', $request->delivery_status);
            $delivery_status = $request->delivery_status;
        }
        if ($request->has('search')){
            $sort_search = $request->search;
            $orders = $orders->where('code', 'like', '%'.$sort_search.'%');
        }
        if ($date != null) {
            $orders = $orders->whereDate('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
        }
        if ($seller_id) {
            $orders = $orders->where('seller_id', $seller_id);
        }

        $orders = $orders->paginate(15);
        return view('backend.sales.seller_orders.index', compact('orders', 'payment_status', 'delivery_status', 'sort_search', 'admin_user_id', 'seller_id', 'date'));
    }

    public function seller_orders_show($id)
    {
        $order = Order::findOrFail(decrypt($id));
        $order->viewed = 1;
        $order->save();
        return view('backend.sales.seller_orders.show', compact('order'));
    }


    // Pickup point orders
    public function pickup_point_order_index(Request $request)
    {
        $date = $request->date;
        $sort_search = null;

        if (auth()->user()->isStaff() && auth()->user()->staff->pick_up_point != null) {
            //$orders = Order::where('pickup_point_id', auth()->user()->staff->pick_up_point->id)->get();
            $orders = DB::table('orders')
                        ->orderBy('code', 'desc')
                        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                        ->where('order_details.pickup_point_id', auth()->user()->staff->pick_up_point->id)
                        ->select('orders.id')
                        ->distinct();

            if ($request->has('search')){
                $sort_search = $request->search;
                $orders = $orders->where('code', 'like', '%'.$sort_search.'%');
            }
            if ($date != null) {
                $orders = $orders->whereDate('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
            }

            $orders = $orders->paginate(15);

            return view('backend.sales.pickup_point_orders.index', compact('orders'));
        }
        else{
            //$orders = Order::where('shipping_type', 'Pick-up Point')->get();
            $orders = DB::table('orders')
                        ->orderBy('code', 'desc')
                        ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                        ->where('order_details.shipping_type', 'pickup_point')
                        ->select('orders.id')
                        ->distinct();

            if ($request->has('search')){
                $sort_search = $request->search;
                $orders = $orders->where('code', 'like', '%'.$sort_search.'%');
            }
            if ($date != null) {
                $orders = $orders->whereDate('orders.created_at', '>=', date('Y-m-d', strtotime(explode(" to ", $date)[0])))->whereDate('orders.created_at', '<=', date('Y-m-d', strtotime(explode(" to ", $date)[1])));
            }

            $orders = $orders->paginate(15);

            return view('backend.sales.pickup_point_orders.index', compact('orders', 'sort_search', 'date'));
        }
    }

    public function pickup_point_order_sales_show($id)
    {
        if (auth()->user()->isStaff()) {
            $order = Order::findOrFail($id);
            return view('backend.sales.pickup_point_orders.show', compact('order'));
        }
        else{
            $order = Order::findOrFail($id);
            return view('backend.sales.pickup_point_orders.show', compact('order'));
        }
    }

    /**
     * Display a single sale to admin.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = new Order;
        if(Auth::check()){
            $order->user_id = auth()->user()->id;
        }
        else{
            $order->guest_id = mt_rand(100000, 999999);
        }

        $order->seller_id = Session::get('owner_id');
        $order->shipping_address = json_encode($request->session()->get('shipping_info'));

        $order->payment_type = $request->payment_option;
        $order->delivery_viewed = '0';
        $order->payment_status_viewed = '0';
        $order->code = date('Ymd-His').rand(10,99);
        $order->date = strtotime('now');

        if($order->save()){
            $subtotal = 0;
            $tax = 0;
            $shipping = 0;

            //calculate shipping is to get shipping costs of different types
            $admin_products = array();
            $seller_products = array();

            //Order Details Storing
            foreach (Session::get('cart')->where('owner_id', Session::get('owner_id')) as $key => $cartItem){
                $product = Product::find($cartItem['id']);

                if($product->added_by == 'admin') {
                    array_push($admin_products, $cartItem['id']);
                }
                else {
                    $product_ids = array();
                    if(array_key_exists($product->user_id, $seller_products)){
                        $product_ids = $seller_products[$product->user_id];
                    }
                    array_push($product_ids, $cartItem['id']);
                    $seller_products[$product->user_id] = $product_ids;
                }

                $subtotal += $cartItem['price']*$cartItem['quantity'];
                $tax += $cartItem['tax']*$cartItem['quantity'];

                $product_variation = $cartItem['variant'];

                if($product_variation != null) {
                    $product_stock = $product->stocks->where('variant', $product_variation)->first();
                    if($product->digital != 1 &&  $cartItem['quantity'] > $product_stock->qty) {
                        flash(translate('The requested quantity is not available for ').$product->getTranslation('name'))->warning();
                        $order->delete();
                        return redirect()->route('cart')->send();
                    }
                    else {
                        $product_stock->qty -= $cartItem['quantity'];
                        $product_stock->save();
                    }
                }
                else {
                    if ($product->digital != 1 && $cartItem['quantity'] > $product->current_stock) {
                        flash(translate('The requested quantity is not available for ').$product->getTranslation('name'))->warning();
                        $order->delete();
                        return redirect()->route('cart')->send();
                    }
                    else {
                        $product->current_stock -= $cartItem['quantity'];
                        $product->save();
//                        $product_stock->qty -= $cartItem['quantity'];
//                        $product_stock->save();
                    }
                }

                $order_detail = new OrderDetail;
                $order_detail->order_id  =$order->id;
                $order_detail->seller_id = $product->user_id;
                $order_detail->product_id = $product->id;
                $order_detail->variation = $product_variation;
                $order_detail->price = $cartItem['price'] * $cartItem['quantity'];
                $order_detail->tax = $cartItem['tax'] * $cartItem['quantity'];
                $order_detail->shipping_type = $cartItem['shipping_type'];
                $order_detail->product_referral_code = $cartItem['product_referral_code'];

                //Dividing Shipping Costs
                $shipping_info = $request->session()->get('shipping_info');

                if ($cartItem['shipping_type'] == 'home_delivery') {
                    $order_detail->shipping_cost = getShippingCost($key);

                    if (isset($cartItem['shipping']) && is_array(json_decode($cartItem['shipping'], true))) {
                        foreach (json_decode($cartItem['shipping'], true) as $shipping_region => $val) {
                            if ($shipping_info['city'] == $shipping_region) {
                                $order_detail->shipping_cost = (double) ($val);
                            } else {
                                $order_detail->shipping_cost = 0;
                            }
                        }
                    } else {
                        if (!$cartItem['shipping']) {
                            $order_detail->shipping_cost = 0;
                        }
                    }
                } else {
                    $order_detail->shipping_cost = 0;
                }
                if($product->is_quantity_multiplied == 1 && get_setting('shipping_type') == 'product_wise_shipping') {
                    $order_detail->shipping_cost = $order_detail->shipping_cost * $cartItem['quantity'];
                }
                $shipping += $order_detail->shipping_cost;

                if ($cartItem['shipping_type'] == 'pickup_point') {
                    $order_detail->pickup_point_id = $cartItem['pickup_point'];
                }
                //End of storing shipping cost

                $order_detail->quantity = $cartItem['quantity'];
                $order_detail->save();

                $product->num_of_sale++;
                $product->save();

                if (\App\Models\Addon::where('unique_identifier', 'affiliate_system')->first() != null &&
                        \App\Models\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {
                    if($order_detail->product_referral_code) {
                        $referred_by_user = User::where('referral_code', $order_detail->product_referral_code)->first();

                        $affiliateController = new AffiliateController;
                        $affiliateController->processAffiliateStats($referred_by_user->id, 0, $order_detail->quantity, 0, 0);
                    }
                }
            }

            $order->grand_total = $subtotal + $tax + $shipping;

            if(Session::has('club_point')){
                $order->grand_total -= Session::get('club_point');
                $clubpointController = new ClubPointController;
                $clubpointController->deductClubPoints($order->user_id, Session::get('club_point'));

                $order->club_point = Session::get('club_point');
            }

            if(Session::has('coupon_discount')){
                $order->grand_total -= Session::get('coupon_discount');
                $order->coupon_discount = Session::get('coupon_discount');

                $coupon_usage = new CouponUsage;
                $coupon_usage->user_id = auth()->user()->id;
                $coupon_usage->coupon_id = Session::get('coupon_id');
                $coupon_usage->save();
            }

            $order->save();

            $array['view'] = 'emails.invoice';
            $array['subject'] = translate('Your order has been placed').' - '.$order->code;
            $array['from'] = env('MAIL_USERNAME');
            $array['order'] = $order;

            foreach($seller_products as $key => $seller_product){
                try {
                    Mail::to(\App\Models\User::find($key)->email)->queue(new InvoiceEmailManager($array));
                } catch (\Exception $e) {

                }
            }

            if (\App\Models\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Models\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\Models\OtpConfiguration::where('type', 'otp_for_order')->first()->value){
                try {
                    $otpController = new OTPVerificationController;
                    $otpController->send_order_code($order);
                } catch (\Exception $e) {

                }
            }

            //sends email to customer with the invoice pdf attached
            if(env('MAIL_USERNAME') != null){
                try {
                    Mail::to($request->session()->get('shipping_info')['email'])->queue(new InvoiceEmailManager($array));
                    Mail::to(User::where('user_type', 'admin')->first()->email)->queue(new InvoiceEmailManager($array));
                } catch (\Exception $e) {

                }
            }

            $request->session()->put('order_id', $order->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if($order != null){
            foreach($order->orderDetails as $key => $orderDetail){
                try {
                    if ($orderDetail->variation != null) {
                        $product_stock = ProductStock::where('product_id', $orderDetail->product_id)->where('variant', $orderDetail->variation)->first();
                        if($product_stock != null){
                            $product_stock->qty += $orderDetail->quantity;
                            $product_stock->save();
                        }
                    }
                    else {
                        $product = $orderDetail->product;
                        $product->current_stock += $orderDetail->quantity;
                        $product->save();
                    }
                } catch (\Exception $e) {

                }

                $orderDetail->delete();
            }
            $order->delete();
            flash(translate('Order has been deleted successfully'))->success();
        }
        else{
            flash(translate('Something went wrong'))->error();
        }
        return back();
    }

    public function order_details(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->save();
        return view('frontend.user.seller.order_details_seller', compact('order'));
    }

    public function update_delivery_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->delivery_viewed = '0';
        $order->delivery_status = $request->status;
        $order->save();

        if(auth()->user()->isSeller()) {
            foreach($order->orderDetails->where('seller_id', auth()->user()->id) as $key => $orderDetail){
                $orderDetail->delivery_status = $request->status;
                $orderDetail->save();

                if($request->status == 'cancelled') {
                    if ($orderDetail->variation != null) {
                        $product_stock = ProductStock::where('product_id', $orderDetail->product_id)
                                ->where('variant', $orderDetail->variation)
                                ->first();
                        if($product_stock != null){
                            $product_stock->qty += $orderDetail->quantity;
                            $product_stock->save();
                        }
                    } else {
                        $product = Product::find($orderDetail->product_id);
                        $product->current_stock += $orderDetail->quantity;
                        $product->save();
                    }
                }
            }
        }
        else {
            foreach ($order->orderDetails as $key => $orderDetail) {
                $orderDetail->delivery_status = $request->status;
                $orderDetail->save();

                if ($request->status == 'cancelled') {
                    if ($orderDetail->variation != null) {
                        $product_stock = ProductStock::where('product_id', $orderDetail->product_id)
                                ->where('variant', $orderDetail->variation)
                                ->first();
                        if ($product_stock != null) {
                            $product_stock->qty += $orderDetail->quantity;
                            $product_stock->save();
                        }
                    } else {
                        $product = Product::find($orderDetail->product_id);
                        $product->current_stock += $orderDetail->quantity;
                        $product->save();
                    }
                }

                if (\App\Models\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Models\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {
                    if (($request->status == 'delivered' || $request->status == 'cancelled') &&
                            $orderDetail->product_referral_code) {

                        $no_of_delivered = 0;
                        $no_of_canceled = 0;

                        if($request->status == 'delivered') {
                            $no_of_delivered = $orderDetail->quantity;
                        }
                        if($request->status == 'cancelled') {
                            $no_of_canceled = $orderDetail->quantity;
                        }

                        $referred_by_user = User::where('referral_code', $orderDetail->product_referral_code)->first();

                        $affiliateController = new AffiliateController;
                        $affiliateController->processAffiliateStats($referred_by_user->id, 0, 0, $no_of_delivered, $no_of_canceled);
                    }
                }
            }
        }

        if (\App\Models\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Models\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\Models\OtpConfiguration::where('type', 'otp_for_delivery_status')->first()->value){
            try {
                $otpController = new OTPVerificationController;
                $otpController->send_delivery_status($order);
            } catch (\Exception $e) {
            }
        }

        return 1;
    }

    public function update_payment_status(Request $request)
    {
        $order = Order::findOrFail($request->order_id);
        $order->payment_status_viewed = '0';
        $order->save();

        if(auth()->user()->isSeller()){
            foreach($order->orderDetails->where('seller_id', auth()->user()->id) as $key => $orderDetail){
                $orderDetail->payment_status = $request->status;
                $orderDetail->save();
            }
        }
        else{
            foreach($order->orderDetails as $key => $orderDetail){
                $orderDetail->payment_status = $request->status;
                $orderDetail->save();
            }
        }

        $status = 'paid';
        foreach($order->orderDetails as $key => $orderDetail){
            if($orderDetail->payment_status != 'paid'){
                $status = 'unpaid';
            }
        }
        $order->payment_status = $status;
        $order->save();


        if($order->payment_status == 'paid' && $order->commission_calculated == 0){
            if(\App\Models\Addon::where('unique_identifier', 'seller_subscription')->first() == null ||
                    !\App\Models\Addon::where('unique_identifier', 'seller_subscription')->first()->activated) {

                if ($order->payment_type == 'cash_on_delivery') {
                    foreach ($order->orderDetails as $key => $orderDetail) {
                        $orderDetail->payment_status = 'paid';
                        $orderDetail->save();
                        $commission_percentage = 0;
                        if (get_setting('category_wise_commission') != 1) {
                            $commission_percentage = get_setting('vendor_commission');
                        } else if($orderDetail->product->user->user_type == 'seller') {
                            $commission_percentage = $orderDetail->product->category->commision_rate;
                        }
                        if($orderDetail->product->user->user_type == 'seller'){
                            $seller = $orderDetail->product->user->seller;
                            $admin_commission = ($orderDetail->price * $commission_percentage)/100;

                            if (get_setting('product_manage_by_admin') == 1) {
                                $seller_earning = ($orderDetail->tax + $orderDetail->price) - $admin_commission;
                                $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->tax + $orderDetail->price) - $admin_commission;
                            } else {
                                $seller_earning = $orderDetail->tax + $orderDetail->shipping_cost + $orderDetail->price - $admin_commission;
                                $seller->admin_to_pay = $seller->admin_to_pay - $admin_commission;
                            }

                            $seller->save();

                            $commission_history = new CommissionHistory;
                            $commission_history->order_id = $order->id;
                            $commission_history->order_detail_id = $orderDetail->id;
                            $commission_history->seller_id = $orderDetail->seller_id;
                            $commission_history->admin_commission = $admin_commission;
                            $commission_history->seller_earning = $seller_earning;

                            $commission_history->save();
                        }

                    }
                }
                elseif($order->manual_payment) {
                    foreach ($order->orderDetails as $key => $orderDetail) {
                        $orderDetail->payment_status = 'paid';
                        $orderDetail->save();
                        $commission_percentage = 0;
                        if (get_setting('category_wise_commission') != 1) {
                            $commission_percentage = BusinessSetting::where('type', 'vendor_commission')->first()->value;
                        } else if($orderDetail->product->user->user_type == 'seller'){
                            $commission_percentage = $orderDetail->product->category->commision_rate;
                        }
                        if($orderDetail->product->user->user_type == 'seller'){
                            $seller = $orderDetail->product->user->seller;
                            $admin_commission = ($orderDetail->price * $commission_percentage)/100;

                            if (get_setting('product_manage_by_admin') == 1) {
                                $seller_earning = ($orderDetail->tax + $orderDetail->price) - $admin_commission;
                                $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price*(100 - $commission_percentage))/100 + $orderDetail->tax;
                            } else {
                                $seller_earning = $orderDetail->tax + $orderDetail->shipping_cost + $orderDetail->price - $admin_commission;
                                $seller->admin_to_pay = $seller->admin_to_pay + ($orderDetail->price*(100 - $commission_percentage))/100 + $orderDetail->tax + $orderDetail->shipping_cost;
                            }

                            $seller->save();

                            $commission_history = new CommissionHistory;
                            $commission_history->order_id = $order->id;
                            $commission_history->order_detail_id = $orderDetail->id;
                            $commission_history->seller_id = $orderDetail->seller_id;
                            $commission_history->admin_commission = $admin_commission;
                            $commission_history->seller_earning = $seller_earning;

                            $commission_history->save();
                        }
                    }
                }
            }

            if (\App\Models\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Models\Addon::where('unique_identifier', 'affiliate_system')->first()->activated) {
                $affiliateController = new AffiliateController;
                $affiliateController->processAffiliatePoints($order);
            }

            if (\App\Models\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Models\Addon::where('unique_identifier', 'club_point')->first()->activated) {
                if ($order->user != null) {
                    $clubpointController = new ClubPointController;
                    $clubpointController->processClubPoints($order);
                }
            }

            $order->commission_calculated = 1;
            $order->save();
        }

        if (\App\Models\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Models\Addon::where('unique_identifier', 'otp_system')->first()->activated && \App\Models\OtpConfiguration::where('type', 'otp_for_paid_status')->first()->value){
            try {
                $otpController = new OTPVerificationController;
                $otpController->send_payment_status($order);
            } catch (\Exception $e) {
            }
        }
        return 1;
    }
}
