<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSellerRequest;
use App\Models\Attribute;
use App\Models\AttributeRelationship;
use App\Models\AttributeValue;
use App\Traits\LoggingTrait;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Session;
use Auth;
use Hash;
use Vendor;
use Categories;
use App\Models\Category;
use App\Models\FlashDeal;
use App\Models\Brand;
use App\Models\Product;
use App\Models\PickupPoint;
use App\Models\CustomerPackage;
use App\Models\User;
use App\Models\Seller;
use App\Models\Shop;
use App\Models\Event;
use App\Models\Color;
use App\Models\Order;
use App\Models\TenantSetting;
use ImageOptimizer;
use Cookie;
use Illuminate\Support\Str;
use App\Mail\SecondEmailVerifyMailManager;
use Mail;
use App\Utility\CategoryUtility;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\LoginRequest;
use App\Models\CategoryRelationship;
use App\Models\Page;

use function foo\func;
use App\Notifications\CompanyVisit;
use Exception;

class HomeController extends Controller
{
    use LoggingTrait;
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('frontend.business_login');
    }

    public function login_users()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function business_login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard');
        }
        return back()->withErrors([
            'incorrect' => 'The provided credentials do not match our records.',
        ]);
    }

    public function registration(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        if (
            $request->has('referral_code') &&
            \App\Models\Addon::where('unique_identifier', 'affiliate_system')->first() != null &&
            \App\Models\Addon::where('unique_identifier', 'affiliate_system')->first()->activated
        ) {

            try {
                $affiliate_validation_time = \App\Models\AffiliateConfig::where('type', 'validation_time')->first();
                $cookie_minute = 30 * 24;
                if ($affiliate_validation_time) {
                    $cookie_minute = $affiliate_validation_time->value * 60;
                }

                Cookie::queue('referral_code', $request->referral_code, $cookie_minute);
                $referred_by_user = User::where('referral_code', $request->product_referral_code)->first();

                $affiliateController = new AffiliateController;
                $affiliateController->processAffiliateStats($referred_by_user->id, 1, 0, 0, 0);
            } catch (\Exception $e) {
            }
        }
        return view('frontend.user_registration');
    }

    public function cart_login(Request $request)
    {
        $user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $request->email)->orWhere('phone', $request->email)->first();
        if ($user != null) {
            if (Hash::check($request->password, $user->password)) {
                if ($request->has('remember')) {
                    auth()->login($user, true);
                } else {
                    auth()->login($user, false);
                }
            } else {
                flash(translate('Invalid email or password!'))->warning();
            }
        }
        return back();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }


    /**
     * Show the customer/seller dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if (auth()->user()->isSeller()) {
            return view('frontend.user.seller.dashboard');
        } elseif (auth()->user()->isCustomer()) {
            return view('frontend.user.customer.dashboard');
        } elseif (auth()->user()->isAdmin()) {
            return view('frontend.user.admin.dashboard');
        }
    }

    public function profile(Request $request)
    {
        if (auth()->user()->isCustomer()) {
            return view('frontend.user.customer.profile');
        } elseif (auth()->user()->isSeller()) {
            return view('frontend.user.seller.profile');
        } else {
            return view('frontend.user.customer.profile');
        }
    }


    /**
     * Show the application frontend home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $products = Product::fromCache()->paginate(12);

        /* Important, if vendor site is activated, then homepage is replaced with single-vendor page */
        if (Vendor::isVendorSite()) {
            $shop = Vendor::getVendorShop();
            return view('frontend.company.profile', compact('shop'));
        } else {


            /* Check if feed is disabled for this tenant */
            if(!get_tenant_setting('feed_disabled', false)) {
                if(auth()->user()) {
                    return redirect()->route('feed.index');
                } else {
                    return view('frontend.index');
                }
            } else {
                $page = Page::where('slug', 'home')->first();
                $sections = $page->content;

                if ($page != null) {
                    return view('frontend.custom_page', [
                        'page' => $page,
                        'sections' => $sections,
                    ]);
                }
            }

            return view('frontend.index');
        }
    }





    public function trackOrder(Request $request)
    {
        if ($request->has('order_code')) {
            $order = Order::where('code', $request->order_code)->first();
            if ($order != null) {
                return view('frontend.track_order', compact('order'));
            }
        }
        return view('frontend.track_order');
    }



    public function all_categories(Request $request)
    {
        //        $categories = Category::where('level', 0)->orderBy('name', 'asc')->get();
        $categories = Category::where('level', 0)->orderBy('order_level', 'desc')->get();
        return view('frontend.all_category', compact('categories'));
    }
    public function all_brands(Request $request)
    {
        $categories = Category::all();
        return view('frontend.brand.index', compact('categories'));
    }




    public function ajax_search(Request $request)
    {
        $keywords = array();
        $products = Product::where('tags', 'like', '%' . $request->search . '%')->get();
        foreach ($products as $key => $product) {
            foreach (explode(',', $product->tags) as $key => $tag) {
                if (stripos($tag, $request->search) !== false) {
                    if (sizeof($keywords) > 5) {
                        break;
                    } else {
                        if (!in_array(strtolower($tag), $keywords)) {
                            array_push($keywords, strtolower($tag));
                        }
                    }
                }
            }
        }

        $products = filter_products(Product::where('name', 'like', '%' . $request->search . '%'))->get()->take(3);

        $categories = Category::where('name', 'like', '%' . $request->search . '%')->get()->take(3);

        $shops = Shop::where('name', 'like', '%' . $request->search . '%')->get()->take(3);

        $events = Event::where('title', 'like', '%' . $request->search . '%')->orWhere('description', 'like', '%' . $request->search . '%')->get()->take(3);

        if (sizeof($keywords) > 0 || sizeof($categories) > 0 || sizeof($products) > 0 || sizeof($shops) > 0) {
            return view('frontend.partials.search_content', compact('products', 'categories', 'keywords', 'shops', 'events'));
        }
        return '0';
    }

    public function listing(Request $request)
    {
        return $this->search($request);
    }

    public function listingByCategory(Request $request, $category_slug)
    {
        $selected_categories = Category::where('slug', $category_slug)->with('children')->get();
        if (!empty($selected_categories) && $selected_categories->isNotEmpty()) {
            return $this->search($request, $selected_categories);
        }

        abort(404); // TODO: Maybe a redirect to All Categories?
        return null;
    }

    public function listingByBrand(Request $request, $brand_slug)
    {
        $brand = Brand::where('slug', $brand_slug)->first();
        if (!empty($brand)) {
            return $this->search($request, null, $brand->id);
        }
        abort(404);
    }

    public function search(Request $request, $selected_categories = null, $brand_id = null)
    {
        $query = $request->q;
        $sort_by = $request->sort_by;
        $seller_id = $request->seller_id;
        $content = $request->content;


        $conditions = [];

        if ($seller_id != null) {
            // ADD TRY CATCH BLOCK to capture the exception on fail!
            $conditions = array_merge($conditions, ['shop_id' => Seller::findOrFail($seller_id)->user->shop->id]);
        }
        $products = Product::where($conditions);

        /* TODO: This probably should be in brand controller and brand archive */
        if ($brand_id != null) {
            $products->where('brand_id', $brand_id);
        }

        if (!empty($selected_categories) && $selected_categories->isNotEmpty()) {
            $products->restrictByCategories($selected_categories);

            /* TODO Check verification for shops */
            $shops = Shop::where('id');
        } else {
            /* TODO Check verification for shops */
            $shops = Shop::where('id');
        }


        if ($query != null) {
            $searchController = new SearchController;
            $searchController->store($request);
            $products = $products->where('name', 'like', '%' . $query . '%');
            $shops = $shops->where('name', 'like', '%' . $query . '%');
        }

        $attributes = array();
        $filters = array();
        $contents = array();
        // Attributes based on Content Type
        if ($content != null) {
            if ($content == 'product') {
                $contents = $products;
            } else if ($content == 'company') {
                $contents = Seller::whereIn('user_id', $shops->get()->pluck('user_id')->toArray());;
            } else if ($content == 'event') {
                $contents = $events;
            }

            $attributeIds = array();
            foreach ($contents->get() as $item) {
                $attributeIds = array_unique(array_merge($attributeIds, $item->custom_attributes()->pluck('attribute_id')->toArray()), SORT_REGULAR);
            }
            $attributes = Attribute::whereIn('id', $attributeIds)->where('type', '<>', 'image')->where('filterable', true)->get();

            foreach ($attributes as $attribute) {
                if ($request->has('attribute_' . $attribute['id']) && $request['attribute_' . $attribute['id']] != "-1" && $request['attribute_' . $attribute['id']] != null) {
                    $filters[$attribute['id']] = $request['attribute_' . $attribute['id']];
                    switch ($attribute->type) {
                        case "number":
                            $range_arr = explode(';', $request['attribute_' . $attribute['id']]);
                            $min_val = floatval($range_arr[0]);
                            $max_val = floatval($range_arr[1]);
                            if ($min_val != null && $max_val != null) {
                                $contents = $contents->whereHas('attributes', function ($relation) use ($min_val, $max_val) {
                                    $relation->whereHas('attribute_value', function ($value) use ($min_val, $max_val) {
                                        $value->where('values', '>=', $min_val)->where('values', '<=', $max_val);
                                    });
                                });
                            }
                            break;
                        case "date":
                            $arr_date_range = explode(" to ", $request['attribute_' . $attribute['id']]);
                            if (count($arr_date_range) > 0) {
                                $date_query = "STR_TO_DATE(`values`, '%d-%m-%Y') >= STR_TO_DATE(?, '%d-%m-%Y') AND STR_TO_DATE(`values`, '%d-%m-%Y') <= STR_TO_DATE(?, '%d-%m-%Y')";
                                $contents = $contents->whereHas('attributes', function ($relation) use ($date_query, $arr_date_range) {
                                    $relation->whereHas('attribute_value', function ($value) use ($date_query, $arr_date_range) {
                                        $value->whereRaw($date_query, $arr_date_range);
                                    });
                                });
                            }
                            break;
                        case "checkbox":
                            $checked_arr = $request['attribute_' . $attribute['id']];
                            $contents = $contents->whereHas('attributes', function ($q) use ($checked_arr) {
                                $q->whereIn('attribute_value_id', $checked_arr);
                            });
                            break;
                        case "country":
                            $code = $request['attribute_' . $attribute['id']];
                            $contents = $contents->whereHas('attributes', function ($relation) use ($code) {
                                $relation->whereHas('attribute_value', function ($value) use ($code) {
                                    $value->where('values', $code);
                                });
                            });
                            break;
                        default:
                            $val_id = $request['attribute_' . $attribute['id']];
                            $contents = $contents->whereHas('attributes', function ($q) use ($val_id) {
                                $q->where('attribute_value_id', $val_id);
                            });
                    }
                }
            }
        }


        /* TODO: Make this to show products by actual category */
        $products = $products->paginate(12);
        $shops = $shops->paginate(10)->appends(request()->query());

        $selected_category = !empty($selected_categories) ? $selected_categories->first() : null;
        return view('frontend.product_listing', compact('products', 'shops', 'attributes', 'query', 'selected_category', 'brand_id', 'sort_by', 'seller_id', 'content', 'contents', 'filters'));
    }


    public function get_pick_ip_points(Request $request)
    {
        $pick_up_points = PickupPoint::all();
        return view('frontend.partials.pick_up_points', compact('pick_up_points'));
    }

    // Form request
    public function update_email(Request $request)
    {
        $email = $request->email;
        if (isUnique($email)) {
            $this->send_email_change_verification_mail($request, $email);
            flash(translate('A verification mail has been sent to the mail you provided us with.'))->success();
            return back();
        }

        flash(translate('Email already exists!'))->warning();
        return back();
    }

    public function send_email_change_verification_mail($request, $email)
    {
        $response['status'] = 0;
        $response['message'] = 'Unknown';

        $verification_code = Str::random(32);

        $array['subject'] = 'Email Verification';
        $array['from'] = env('MAIL_USERNAME');
        $array['content'] = 'Verify your account';
        $array['link'] = route('email_change.callback') . '?new_email_verificiation_code=' . $verification_code . '&email=' . $email;
        $array['sender'] = auth()->user()->name;
        $array['details'] = "Email Second";

        $user = auth()->user();
        $user->new_email_verificiation_code = $verification_code;
        $user->save();

        try {
            Mail::to($email)->queue(new SecondEmailVerifyMailManager($array));

            $response['status'] = 1;
            $response['message'] = translate("Your verification mail has been Sent to your email.");
        } catch (\Exception $e) {
            // return $e->getMessage();
            $response['status'] = 0;
            $response['message'] = $e->getMessage();
        }

        return $response;
    }

    public function email_change_callback(Request $request)
    {
        if ($request->has('new_email_verificiation_code') && $request->has('email')) {
            $verification_code_of_url_param =  $request->input('new_email_verificiation_code');
            $user = User::where('new_email_verificiation_code', $verification_code_of_url_param)->first();

            if ($user != null) {

                $user->email = $request->input('email');
                $user->new_email_verificiation_code = null;
                $user->save();

                auth()->login($user, true);

                flash(translate('Email Changed successfully'))->success();
                return redirect()->route('dashboard');
            }
        }

        flash(translate('Email was not verified. Please resend your mail!'))->error();
        return redirect()->route('dashboard');
    }

    public function reset_password_with_code(Request $request)
    {
        if (($user = User::where('email', $request->email)->where('verification_code', $request->code)->first()) != null) {
            if ($request->password == $request->password_confirmation) {
                $user->password = Hash::make($request->password);
                $user->email_verified_at = date('Y-m-d h:m:s');
                $user->save();
                event(new PasswordReset($user));
                auth()->login($user, true);

                flash(translate('Password updated successfully'))->success();

                if (auth()->user()->isAdmin() || auth()->user()->isStaff()) {
                    return redirect()->route('admin.dashboard');
                }
                return redirect()->route('home');
            } else {
                flash("Password and confirm password didn't match")->warning();
                return back();
            }
        } else {
            flash("Verification code mismatch")->error();
            return back();
        }
    }



    public function all_seller(Request $request, $category_id = null)
    {

        $query = $request->q;
        $min_employee = $request->min_employee;
        $max_employee = $request->max_employee;

        $conditions = [];


        $shops = Shop::whereIn('user_id', verified_sellers_id());

        if ($min_employee != null && $max_employee != null) {
            // $shops = $shops->where()
        }

        if ($category_id != null) {
            $category_ids = CategoryUtility::children_ids($category_id);
            $category_ids[] = $category_id;

            $shops = $shops->whereIn('category_id', $category_ids);
        }

        $attributes = array();
        foreach ($shops as $shop) {
            if ($shop->attributes != null && is_array(json_decode($shop->attributes))) {
                foreach (json_decode($shop->attributes) as $key => $value) {
                    $flag = false;
                    $pos = 0;
                    foreach ($attributes as $attribute) {
                        if ($attribute['id'] == $value) {
                            $flag = true;
                            $pos = $key;
                            break;
                        }
                    }
                    if (!$flag) {
                        $item['id'] = $value;
                        $item['values'] = array();
                        foreach (json_decode($product->choice_options) as $choice_option) {
                            if ($choice_option->attribute_id == $value) {
                                $item['values'] = $choice_option->values;
                                break;
                            }
                        }
                        array_push($attributes, $item);
                    } else {
                        foreach (json_decode($product->choice_options) as $choice_option) {
                            if ($choice_option->attribute_id == $value) {
                                foreach ($choice_option->values as $value) {
                                    if (!in_array($value, $attributes[$pos]['values'])) {
                                        array_push($attributes[$pos]['values'], $value);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $selected_attributes = array();
        foreach ($attributes as $attribute) {
            if ($request->has('attributes_' . $attribute['id'])) {
                foreach ($request['attributes_' . $attribute['id']] as $value) {
                    $str = '"' . $value . '"';
                    $shops = $shops->where('choice_options', 'like', '%' . $str . '%');
                }
                $item['id'] = $attribute['id'];
                $item['values'] = $request['attributes_' . $attribute['id']];
                array_push($selected_attributes, $item);
            }
        }

        // return view('frontend.shop_listing', compact('shops', 'attributes', 'category_id', 'selected_attributes'));
    }
}
