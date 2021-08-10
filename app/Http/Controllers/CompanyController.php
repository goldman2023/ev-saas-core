<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Category;
use App\Models\Seller;
use App\Models\Attribute;
use App\Models\Review;
use App\Models\ReviewRelationship;
use App\Traits\LoggingTrait;
use Illuminate\Http\Request;
use DB;

class CompanyController extends Controller
{
    use LoggingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $category_id = null)
    {
        $title = '';

        if ($category_id != null) {
            $category = Category::find($category_id);
            $shops = $category->companies();
            $shops = $shops->whereIn('user_id', verified_sellers_id());
            $title = $category->name . ' Companies';
        } else {
            $category = Category::all();

            $shops = Shop::whereIn('user_id', verified_sellers_id());
        }

        $attributeIds = array();
        $sellers = Seller::whereIn('user_id', $shops->get()->pluck('user_id')->toArray());
        foreach ($sellers->get() as $seller) {
            $attributeIds = array_unique(array_merge($attributeIds, $seller->attributes->pluck('attribute_id')->toArray()), SORT_REGULAR);
        }
        $attributes = Attribute::whereIn('id', $attributeIds)->where('filterable', true)->get();

        $filters = array();
        foreach ($attributes as $attribute) {
            if ($request->has('attribute_' . $attribute['id']) && $request['attribute_' . $attribute['id']] != null) {
                $filters[$attribute['id']] = $request['attribute_' . $attribute['id']];
                switch ($attribute->type) {
                    case "number":
                        $min_val = $request['attribute_' . $attribute['id']][0];
                        $max_val = $request['attribute_' . $attribute['id']][1];
                        if ($min_val != null && $max_val != null) {
                            $sellers = $sellers->whereHas('attributes', function ($relation) use ($min_val, $max_val) {
                                $relation->whereHas('attribute_value', function ($value) use ($min_val, $max_val) {
                                    $value->where('values', '>=', $min_val)->where('values', '<=', $max_val);
                                });
                            });
                        }
                        break;
                    case "date":
                        $arr_date_range = explode(" to ", $request['attribute_' . $attribute['id']]);
                        if (count($arr_date_range) > 0) {
                            $query = "STR_TO_DATE(`values`, '%d-%m-%y') >= STR_TO_DATE(?, '%d-%m-%y') AND STR_TO_DATE(`values`, '%d-%m-%y') <= STR_TO_DATE(?, '%d-%m-%y')";
                            $sellers = $sellers->whereHas('attributes', function ($relation) use ($query, $arr_date_range) {
                                $relation->whereHas('attribute_value', function ($value) use ($query, $arr_date_range) {
                                    $value->whereRaw($query, $arr_date_range);
                                });
                            });
                        }
                        break;
                    case "checkbox":
                        $checked_arr = $request['attribute_' . $attribute['id']];
                        $sellers = $sellers->whereHas('attributes', function ($q) use ($checked_arr) {
                            $q->whereIn('attribute_value_id', $checked_arr);
                        });
                        break;
                    case "country":
                        $code = $request['attribute_' . $attribute['id']];
                        $sellers = $sellers->whereHas('attributes', function ($relation) use ($code) {
                            $relation->whereHas('attribute_value', function ($value) use ($code) {
                                $value->where('values', $code);
                            });
                        });
                        break;
                    default:
                        $val_id = $request['attribute_' . $attribute['id']];
                        $sellers = $sellers->whereHas('attributes', function ($q) use ($val_id) {
                            $q->where('attribute_value_id', $val_id);
                        });
                }
            }
        }

        $shops = $shops->whereIn('user_id', $sellers->get()->pluck('user_id')->toArray())->paginate(12);
        return view('frontend.shop_listing', compact('shops', 'attributes', 'category_id', 'filters', 'title'));
    }

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Shop $shop, $slug, $type)
    {
        //
        $shop  = Shop::where('slug', $slug)->first();
        if ($shop != null) {
            $seller = Seller::where('user_id', $shop->user_id)->first();
            if ($seller->verification_status != 0) {
                if ($request->sort_type) {
                    $sort = $request->sort_type;
                    return view('frontend.company.sub-pages.' . $type, compact('shop', 'seller', 'sort'));
                }
                return view('frontend.company.sub-pages.' . $type, compact('shop', 'seller'));
            } else {
                if (auth()) {
                    if (auth()->user()->id === $shop->user->id) {
                        return view('frontend.company.sub-pages.' . $type, compact('shop', 'seller'));
                    }
                } else {
                    return view('frontend.seller_shop_without_verification', compact('shop', 'seller'));
                }
            }
        }
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        //
    }

    public function listingByCategory(Request $request, $category_slug)
    {
        $category = Category::where('slug', $category_slug)->first();
        if ($category != null) {
            return $this->index($request, $category->id);
        }
        abort(404);
    }

    public function thankYouPage()
    {
        return view('frontend.company.thank-you');
    }

    /**
     * used to track if the user clicks on website url
     * @param $id
     */
    public function track_website_clicks($id)
    {
        $company = Shop::findOrFail($id);
        if($company){
            $utm_query = [
                'utm_source' => 'b2bwood',
            ];
            visits($company,'website_click')->increment();
            if(auth()->user())
            {
                $this->log($company,"user clicked on the following company website");
            }
            return redirect()->away(qs_url($company->get_company_website_url()['href'],$utm_query));
        }else{
            return back();
        }
    }
}
