<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellerPackage;
use App\Models\SellerPackageTranslation;
use App\Models\SellerPackagePayment;
use Auth;
use Session;
Use App\Models\User;
Use App\Models\Seller;
use Carbon\Carbon;

class SellerPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seller_packages = SellerPackage::all();
        return view('seller_packages.index',compact('seller_packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('seller_packages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $seller_package = new SellerPackage;
        $seller_package->name = $request->name;
        $seller_package->amount = $request->amount;
        $seller_package->product_upload = $request->product_upload;
        $seller_package->digital_product_upload = $request->digital_product_upload;
        $seller_package->duration = $request->duration;
        $seller_package->logo = $request->logo;
        if($seller_package->save()){

            $seller_package_translation = SellerPackageTranslation::firstOrNew(['lang' => config('app.locale'), 'seller_package_id' => $seller_package->id]);
            $seller_package_translation->name = $request->name;
            $seller_package_translation->save();

            flash(translate('Package has been inserted successfully'))->success();
            return redirect()->route('admin.seller_packages.index');
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $lang   = $request->lang;
        $seller_package = SellerPackage::findOrFail($id);
        return view('seller_packages.edit', compact('seller_package','lang'));
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
        $seller_package = SellerPackage::findOrFail($id);
        if($request->lang == config('app.locale')){
            $seller_package->name = $request->name;
        }
        $seller_package->amount = $request->amount;
        $seller_package->product_upload = $request->product_upload;
        $seller_package->digital_product_upload = $request->digital_product_upload;
        $seller_package->duration = $request->duration;
        $seller_package->logo = $request->logo;
        if($seller_package->save()){

            if($request->lang) {

            } else {
                $request->lang = 'en';
            }

            $seller_package_translation = SellerPackageTranslation::firstOrNew(['lang' => $request->lang, 'seller_package_id' => $seller_package->id]);
            $seller_package_translation->name = $request->name;
            $seller_package_translation->save();
            flash(translate('Package has been inserted successfully'))->success();
            return redirect()->route('admin.seller_packages.index');
        }
        else{
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seller_package = SellerPackage::findOrFail($id);
        foreach ($seller_package->seller_package_translations as $key => $seller_package_translation) {
            $seller_package_translation->delete();
        }
        SellerPackage::destroy($id);
        flash(translate('Package has been deleted successfully'))->success();
        return redirect()->route('admin.seller_packages.index');
    }


    //FrontEnd
    //@index
    public function seller_packages_list()
    {
        $seller_packages = SellerPackage::all();
        return view('seller_packages.frontend.seller_packages_list',compact('seller_packages'));
    }

    public function purchase_package(Request $request)
    {
        $data['seller_package_id'] = $request->seller_package_id;
        $data['payment_method'] = $request->payment_option;

        $request->session()->put('payment_type', 'seller_package_payment');
        $request->session()->put('payment_data', $data);

        $seller_package = SellerPackage::findOrFail(Session::get('payment_data')['seller_package_id']);
        if($seller_package->amount == 0){
            if(auth()->user()->seller->seller_package_id != $seller_package->id){
                return $this->purchase_payment_done(Session::get('payment_data'), null);
            }
            else {
                flash(translate('You can not purchase this package anymore.'))->warning();
                return back();
            }
        }

        if($request->payment_option == 'paypal'){
            $paypal = new PaypalController;
            return $paypal->getCheckout();
        }
        elseif ($request->payment_option == 'stripe') {
            $stripe = new StripePaymentController;
            return $stripe->stripe();
        }
        elseif ($request->payment_option == 'sslcommerz_payment') {
            $sslcommerz = new PublicSslCommerzPaymentController;
            return $sslcommerz->index($request);
        }
        elseif ($request->payment_option == 'instamojo') {
            $instamojo = new InstamojoController;
            return $instamojo->pay($request);
        }
        elseif ($request->payment_option == 'razorpay') {
            $razorpay = new RazorpayController;
            return $razorpay->payWithRazorpay($request);
        }
        elseif ($request->payment_option == 'paystack') {
            $paystack = new PaystackController;
            return $paystack->redirectToGateway($request);
        }
    }

    public function purchase_payment_done($payment_data, $payment){
        $seller = auth()->user()->seller;
        $seller->seller_package_id = Session::get('payment_data')['seller_package_id'];
        $seller_package = SellerPackage::findOrFail(Session::get('payment_data')['seller_package_id']);
        $seller->remaining_uploads += $seller_package->product_upload;
        $seller->remaining_digital_uploads += $seller_package->digital_product_upload;
        $seller->invalid_at = date('Y-m-d', strtotime( $seller->invalid_at. ' +'. $seller_package->duration .'days'));
        $seller->save();

        flash(translate('Package purchasing successful'))->success();
        return redirect()->route('dashboard');
    }

    public function unpublish_products(Request $request){
        foreach (Seller::all() as $key => $seller) {
            if($seller->invalid_at != null && Carbon::now()->diffInDays(Carbon::parse($seller->invalid_at), false) <= 0){
                foreach ($seller->user->products as $key => $product) {
                    $product->published = 0;
                    $product->save();
                }
            }
        }
    }

    public function purchase_package_offline(Request $request){
        $seller_package = new SellerPackagePayment;
        $seller_package->user_id = auth()->user()->id;
        $seller_package->seller_package_id = $request->package_id;
        $seller_package->payment_method = $request->payment_option;
        $seller_package->payment_details = $request->trx_id;
        $seller_package->approval = 0;
        $seller_package->offline_payment = 1;
        $seller_package->reciept = $request->photo;
        $seller_package->save();
        flash(translate('Offline payment has been done. Please wait for response.'))->success();
        return redirect()->route('seller.products');
    }
}
