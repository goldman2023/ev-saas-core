<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seller;
use App\Models\User;
use App\Models\Shop;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\AttributeRelationship;
use Illuminate\Support\Facades\Hash;
use App\Notifications\EmailVerificationNotification;
use App\DataTables\SellerDataTable;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $approved = null;
        $sellers = Seller::orderBy('created_at', 'desc');
        if ($request->has('search')){
            $sort_search = $request->search;
            $user_ids = User::where('user_type', 'seller')->where(function($user) use ($sort_search){
                $user->where('name', 'like', '%'.$sort_search.'%')->orWhere('email', 'like', '%'.$sort_search.'%');
            })->pluck('id')->toArray();
            $sellers = $sellers->where(function($seller) use ($user_ids){
                $seller->whereIn('user_id', $user_ids);
            });
        }
        if ($request->approved_status != null) {
            $approved = $request->approved_status;
            $sellers = $sellers->where('verification_status', $approved);
        }
        $sellers = $sellers->paginate(15);
        return view('backend.sellers.index', compact('sellers', 'sort_search', 'approved'));
    }

        $sellers = Seller::all();
        return view('backend.sellers.index', compact('sellers', 'sort_search', 'approved'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attributes = Attribute::where('content_type', 'App\Models\Seller')->orderBy('created_at', 'desc')->get();
        return view('backend.sellers.create', compact('attributes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(User::where('email', $request->email)->first() != null){
            flash(translate('Email already exists!'))->error();
            return back();
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = "seller";
        $user->password = Hash::make($request->password);
        if($user->save()){
            if(get_setting('email_verification') != 1){
                $user->email_verified_at = date('Y-m-d H:m:s');
            }
            else {
                $user->notify(new EmailVerificationNotification());
            }
            $user->save();

            $seller = new Seller;
            $seller->user_id = $user->id;
            if($seller->save()){
                $shop = new Shop;
                $shop->slug = 'demo-shop-'.$user->id;
                $shop->save();
                $shop->users()->attach($user);

                flash(translate('Seller has been inserted successfully'))->success();
                return redirect()->route('admin.sellers.index');
            }
        }
        flash(translate('Something went wrong'))->error();
        return back();
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
    public function edit($id)
    {
        $seller = Seller::findOrFail($id);
        $attributes = Attribute::where('content_type', 'App\Models\Seller')->orderBy('created_at', 'desc')->get();
        return view('backend.sellers.edit', compact(['seller', 'attributes']));
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
        $seller = Seller::findOrFail($id);
        // Seller Attribute Update
        $updated_attributes = $request->except(['_method', '_token', 'name', 'email', 'password']);
        foreach($updated_attributes as $key => $value) {
            $attribute_relationship = $seller->attributes->where('attribute_id', $key)->first();

            $attribute = Attribute::find($key);

            if(empty($attribute)) {
                continue;
            }

            if ($value != null) {
                $relationship_id = $value;
                if ($attribute->type != "dropdown" && $attribute->type != "checkbox") {
                    if ($attribute_relationship == null) {
                        $attribute_value = new AttributeValue;
                        $attribute_value->attribute_id = $attribute->id;
                    }else {
                        $attribute_value = AttributeValue::findOrFail($attribute_relationship->attribute_value_id);
                    }
                    $attribute_value->values = $value;
                    $attribute_value->save();
                    $relationship_id = $attribute_value->id;
                }

                if ($attribute->type != "checkbox") {
                    if ($attribute_relationship == null) {
                        $attribute_relationship = new AttributeRelationship;
                        $attribute_relationship->subject_type = "App\Models\Seller";
                        $attribute_relationship->subject_id = $id;
                        $attribute_relationship->attribute_id = $key;
                    }
                    $attribute_relationship->attribute_value_id = $relationship_id;
                    $attribute_relationship->save();
                }else {
                    foreach($seller->attributes->where('attribute_id', $key)->whereNotIn('attribute_value_id', $value) as $relation) {
                        $relation->delete();
                    }
                    foreach($value as $index => $option) {
                        if (count($seller->attributes->where('attribute_id', $key)->where('attribute_value_id', $option)) == 0) {
                            $attribute_relationship = new AttributeRelationship;
                            $attribute_relationship->subject_type = "App\Models\Seller";
                            $attribute_relationship->subject_id = $id;
                            $attribute_relationship->attribute_id = $key;
                            $attribute_relationship->attribute_value_id = $option;
                            $attribute_relationship->save();
                        }
                    }
                }
            }else {
                if ($attribute->type == "checkbox") {
                    foreach($seller->attributes->where('attribute_id', $key) as $relation) {
                        $relation->delete();
                    }
                }else if ($attribute_relationship != null){
                    $attribute_value = AttributeValue::findOrFail($attribute_relationship->attribute_value_id);
                    $attribute_relationship->delete();
                    $attribute_value->delete();
                }
            }
        }
        // Seller Information Update
        $user = $seller->user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->shop->name = $request->company_name;
        $user->shop->save();

        if(strlen($request->password) > 0){
            $user->password = Hash::make($request->password);
        }
        if($user->save()){
            if($seller->save()){
                flash(translate('Seller has been updated successfully'))->success();
                return redirect()->route('admin.sellers.index');
            }
        }

        flash(translate('Something went wrong'))->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seller = Seller::findOrFail($id);
        Shop::where('user_id', $seller->user_id)->delete();
        Product::where('user_id', $seller->user_id)->delete();
        Order::where('user_id', $seller->user_id)->delete();
        OrderDetail::where('seller_id', $seller->user_id)->delete();
        User::destroy($seller->user->id);
        if(Seller::destroy($id)){
            flash(translate('Seller has been deleted successfully'))->success();
            return redirect()->route('admin.sellers.index');
        }
        else {
            flash(translate('Something went wrong'))->error();
            return back();
        }
    }

    public function show_verification_request($id)
    {
        $seller = Seller::findOrFail($id);
        return view('backend.sellers.verification', compact('seller'));
    }

    public function approve_seller($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->verification_status = 1;
        if($seller->save()){
            flash(translate('Seller has been approved successfully'))->success();
            return redirect()->route('admin.sellers.index');
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }

    public function reject_seller($id)
    {
        $seller = Seller::findOrFail($id);
        $seller->verification_status = 0;
        $seller->verification_info = null;
        if($seller->save()){
            flash(translate('Seller verification request has been rejected successfully'))->success();
            return redirect()->route('admin.sellers.index');
        }
        flash(translate('Something went wrong'))->error();
        return back();
    }


    public function payment_modal(Request $request)
    {
        $seller = Seller::findOrFail($request->id);
        return view('backend.sellers.payment_modal', compact('seller'));
    }

    public function profile_modal(Request $request)
    {
        $seller = Seller::findOrFail($request->id);
        return view('backend.sellers.profile_modal', compact('seller'));
    }

    public function updateApproved(Request $request)
    {
        $seller = Seller::findOrFail($request->id);
        $seller->verification_status = $request->status;
        if($seller->save()){
            return 1;
        }
        return 0;
    }

    public function login($id)
    {
        $seller = Seller::findOrFail($id);

        $user  = $seller->user;

        auth()->login($user, true);

        return redirect()->route('dashboard');
    }

    public function ban($id) {
        $seller = Seller::findOrFail($id);

        if($seller->user->banned == 1) {
            $seller->user->banned = 0;
            flash(translate('Seller has been unbanned successfully'))->success();
        } else {
            $seller->user->banned = 1;
            flash(translate('Seller has been banned successfully'))->success();
        }

        $seller->user->save();
        return back();
    }
}
