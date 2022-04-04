<?php

namespace App\Http\Controllers;

use App\Facades\StripeService;
use EVS;
use App\Models\Product;
use App\Models\Shop;
use Auth;
use Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;
use Stripe;

class EVProductController extends Controller
{
    //
    public function index(Request $request) {
        $products = Auth::user()->products()->orderBy('created_at','desc')->paginate(20);
        return view('frontend.dashboard.products.index')->with('products', $products);
    }

    public function create(Request $request) {
        return view('frontend.dashboard.products.create');
    }

    public function create2(Request $request) {
        return view('frontend.dashboard.products.create2');
    }

    /* TODO: Add middleware for owner */
    public function edit(Request $request, $slug) {
        $product = Product::where('slug', $slug)->first();

        if($product) {
            // $product->convertUploadModelsToIDs(); // DEPRECATED, since we use livewire and alpinejs combo instead of shitty Front JS
        }

        return view('frontend.dashboard.products.edit')->with('product', $product);
    }

    public function edit_stocks(Request $request, $slug) {
        $product = Product::where('slug', $slug)->first();

        if($product) {
            $product->convertUploadModelsToIDs();
        }

        return view('frontend.dashboard.products.stocks')
            ->with('product', $product)
            ->with('variations_attributes', $product->variant_attributes());
    }

    public function edit_variations(Request $request, $slug) {
        $product = Product::where('slug', $slug)->first();

        if($product) {
            $product->convertUploadModelsToIDs();
        }

        return view('frontend.dashboard.products.variations')
        ->with('product', $product)
        ->with('variations_attributes', $product->variant_attributes());
    }

    public function product_details(Request $request, $slug) {
        $product = Product::where('slug', $slug)->first();

        return view('frontend.dashboard.products.details')->with('product', $product);
    }

    public function product_activity(Request $request, $slug) {
        $product = Product::where('slug', $slug)->first();

        $activity = Activity::all();

        $activity = Activity::where('subject_type', 'App\Models\Product')->where('subject_id', $product->id)->first();
        return view('frontend.dashboard.products.activity')->with('product', $product);
    }

    // Frontend
    public function productsByCategory(Request $request, $slug) {
        $selected_category = Categories::getAll(true)->get(Categories::getCategorySlugFromRoute($slug));
        $products = $selected_category->products()->orderBy('created_at', 'DESC')->paginate(10);
        $shops = $selected_category->shops()->orderBy('created_at', 'DESC')->paginate(10);

        // TODO: Init Filters here

        // TODO: return view

//        $selected_categories = Category::where('slug', $category_slug)->with('children')->get();
//        if (!empty($selected_categories) && $selected_categories->isNotEmpty()) {
//            return $this->search($request, $selected_categories);
//        }
//
//        abort(404); // TODO: Maybe a redirect to All Categories?
//        return null;
        return view('frontend.products.archive', compact('products', 'shops', 'selected_category'));
    }


    public function show(Request $request, $slug)
    {
        /* TODO This is duplicate for consistent naming, let's refactor to better approach */
        $product  = Product::where('slug', $slug)->first()->load(['shop']);
//        dd($product->custom_attributes);
        if (empty($product->shop)) {
            /* TODO: Default value for products with no shops falls back to shop_id 1 */
            $product->shop = Shop::first();
        }

        /* TODO: add this eventually: && $product->published */
        if (!empty($product) ) {

            if (auth()->check()) {
                $user = auth()->user();
            } else {
                $user = null;
            }

            activity()
                ->performedOn($product)
                ->causedBy($user)
                ->withProperties([
                    'action' => 'viewed',
                    'action_title' => 'Viewed a product',
                    ] )
                ->log('viewed');
        }
        /* TODO: Make this optional (style1/style2/etc) per tenant/vendor */

        $template = 'product-single-1';
        return view('frontend.product.single.' . $template, compact('product'));
    }

    public function createProductCheckoutRedirect($id, $qty = 1) {
        $product = Product::find($id);
        $link = StripeService::createCheckoutLink($product, $qty);
        return redirect($link);
    }

}
