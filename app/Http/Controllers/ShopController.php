<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateShopRequest;
use App\Traits\LoggingTrait;
use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\User;
use App\Models\Seller;
use App\Models\BusinessSetting;
use App\Models\AttributeRelationship;
use App\Models\AttributeValue;
use Auth;
use Hash;
use App\Notifications\EmailVerificationNotification;
use App\Notifications\NewCompanyJoin;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\ShopRequest;
use Spatie\Newsletter\NewsletterFacade;
class ShopController extends Controller
{
    use LoggingTrait;
    public function __construct()
    {
        $this->middleware('user', ['only' => ['index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop = auth()->user()->shop;
        return view('frontend.user.seller.shop', compact('shop'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::check() && auth()->user()->isAdmin()) {
            flash(translate('Admin can not be a seller'))->error();
            return back();
        } else {
            return view('frontend.registration.company_registration');
        }
    }

    /**
     *
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopRequest $request)
    {

        $validated = $request->validated();

        $user = null;
        if (!Auth::check()) {
            if (User::where('email', $request->email)->first() != null) {
                flash(translate('Email already exists!'))->error();
                return back();
            }
            if ($request->password == $request->password_confirmation) {
                $user = new User;
                $user->name = $request->name;
                $user->email = $request->email;
                $user->user_type = "seller";
                $user->phone = $request->phone_number;
                $news = NewsletterFacade::subscribe($request->email, ['FNAME'=>$request->name, 'LNAME'=>""]);
                $user->password = Hash::make($request->password);
                $user->save();
                $this->simpleLog("New User Created and Registered to newsletter using email: ".$user->email);
            } else {
                flash(translate('Sorry! Password did not match.'))->error();
                return back();
            }
        } else {
            $user = auth()->user();
            if ($user->customer != null) {
                $user->customer->delete();
            }
            $user->user_type = "seller";
            $user->save();
        }

        $seller = new Seller;
        $seller->user_id = $user->id;
        $seller->save();


        /* Assign County Atttibute */
        $value = AttributeValue::where('values', $request->country)->first();
        if (!$value) {
            $attributeValueCountry = new AttributeValue();
            $attributeValueCountry->attribute_id = 12;
            $attributeValueCountry->values = $request->country;
            $attributeValueCountry->save();
        }

        $value = AttributeValue::where('values', $request->country)->first();


        if ($value) {
            $attribute_relationship_country = new AttributeRelationship;
            $attribute_relationship_country->subject_type = "App\Models\Seller";
            $attribute_relationship_country->subject_id = $user->seller->id;
            $attribute_relationship_country->attribute_id = 12;
            $attribute_relationship_country->attribute_value_id = $value->id;
            $attribute_relationship_country->save();
        }

        $user->save();
        if (Shop::where('user_id', $user->id)->first() == null) {
            $shop = new Shop;
            $shop->user_id = $user->id;
            $shop->name = $request->company_name;
            $shop->address = $request->address;
            $shop->slug = preg_replace('/\s+/', '-', $request->name) . '-' . $shop->id;

            if ($shop->save()) {
                auth()->login($user, false);
                if (BusinessSetting::where('type', 'email_verification')->first()->value != 1) {
                    $user->email_verified_at = date('Y-m-d H:m:s');
                    $user->save();
                    Notification::send(User::where('id', '!=', $user->id)->get(), new NewCompanyJoin($user));
                } else {
                    $user->notify(new EmailVerificationNotification());
                }
                flash(translate('Your Company has been created successfully!'))->success();

                /* TODO: ADD user to mailchimp for welcome email: */

                return redirect()->route('seller_packages_list');
            } else {
                $seller->delete();
                $user->user_type == 'customer';
                $user->save();
            }
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShopRequest $request, $id)
    {
        $shop = Shop::find($id);

        if ($request->has('name') && $request->has('address')) {
            $shop->name = $request->name;
            if ($request->has('shipping_cost')) {
                $shop->shipping_cost = $request->shipping_cost;
            }
            $shop->address = $request->address;
            $shop->slug = preg_replace('/\s+/', '-', $request->name) . '-' . $shop->id;

            $shop->meta_title = $request->meta_title;
            $shop->meta_description = $request->meta_description;
            $shop->logo = $request->logo;
            if ($request->has('pick_up_point_id')) {
                $shop->pick_up_point_id = json_encode($request->pick_up_point_id);
            } else {
                $shop->pick_up_point_id = json_encode(array());
            }
        } elseif ($request->has('facebook') || $request->has('google') || $request->has('twitter') || $request->has('linkedin') || $request->has('instagram')) {
            $shop->facebook = $request->facebook;
            $shop->google = $request->instagram;
            $shop->twitter = $request->twitter;
            $shop->youtube = $request->linkedin;
        } else {
            $shop->sliders = $request->sliders;
        }

        if ($shop->save()) {
            flash(translate('Your Company Details has been updated successfully!'))->success();
            return back();
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function verify_form(ShopRequest $request)
    {
        if (auth()->user()->seller->verification_info == null) {
            $shop = auth()->user()->shop;
            return view('frontend.user.seller.verify_form', compact('shop'));
        } else {
            flash(translate('Sorry! You have sent verification request already.'))->error();
            return back();
        }
    }

    public function verify_form_store(ShopRequest $request)
    {
        $data = array();
        $i = 0;
        foreach (json_decode(BusinessSetting::where('type', 'verification_form')->first()->value) as $key => $element) {
            $item = array();
            if ($element->type == 'text') {
                $item['type'] = 'text';
                $item['label'] = $element->label;
                $item['value'] = $request['element_' . $i];
            } elseif ($element->type == 'select' || $element->type == 'radio') {
                $item['type'] = 'select';
                $item['label'] = $element->label;
                $item['value'] = $request['element_' . $i];
            } elseif ($element->type == 'multi_select') {
                $item['type'] = 'multi_select';
                $item['label'] = $element->label;
                $item['value'] = json_encode($request['element_' . $i]);
            } elseif ($element->type == 'file') {
                $item['type'] = 'file';
                $item['label'] = $element->label;
                $item['value'] = $request['element_' . $i]->store('uploads/verification_form');
            }
            array_push($data, $item);
            $i++;
        }
        $seller = auth()->user()->seller;
        $seller->verification_info = json_encode($data);
        if ($seller->save()) {
            flash(translate('Your company verification request has been submitted successfully!'))->success();
            return redirect()->route('dashboard');
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }
}
