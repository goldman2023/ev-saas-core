<?php

namespace App\Http\Controllers;

use App\Facades\MyShop;
use App\Facades\StripeService;
use App\Models\Product;
use App\Models\Shop;
use Auth;
use Categories;
use EVS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;
use Stripe;

class EVProductController extends Controller
{
    //
    public function index(Request $request)
    {
        if (Auth::user()->user_type == 'admin') {
            $products = Product::orderBy('created_at', 'desc')->paginate(20);
        } else {
            $products = Auth::user()->products()->orderBy('created_at', 'desc')->paginate(20);
        }

        return view('frontend.dashboard.products.index')->with('products', $products);
    }

    public function create(Request $request)
    {
        return view('frontend.dashboard.products.create');
    }

    public function create2(Request $request)
    {
        /* Check if user has shop */
        if (!MyShop::getShop()) {
            /* If not, redirect to shop creation */
            return redirect()->route('onboarding.step3');
        }

        return view('frontend.dashboard.products.create2');
    }

    /* TODO: Add middleware for owner */
    public function edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        return view('frontend.dashboard.products.edit')->with('product', $product);
    }

    public function edit_stocks(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product) {
            $product->convertUploadModelsToIDs();
        }

        return view('frontend.dashboard.products.stocks')
            ->with('product', $product)
            ->with('variations_attributes', $product->variant_attributes());
    }

    public function edit_variations(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product) {
            $product->convertUploadModelsToIDs();
        }

        return view('frontend.dashboard.products.variations')
            ->with('product', $product)
            ->with('variations_attributes', $product->variant_attributes());
    }

    public function product_details(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        return view('frontend.dashboard.products.details')->with('product', $product);
    }

    public function product_activity(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $activity = Activity::all();

        $activity = Activity::whereHas('subject')->where('subject_type', \App\Models\Product::class)->where('subject_id', $product->id)->first();

        return view('frontend.dashboard.products.activity')->with('product', $product);
    }

    public function thank_you_preview(Request $request, $id) {
        $product = Product::findOrFail($id);

        return view('frontend.dashboard.products.thank-you-preview')->with('product', $product);
    }

    // Frontend
    public function productsByCategory(Request $request, $slug)
    {
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
        if (Product::where('slug', $slug)->first()) {
            $product = Product::where('slug', $slug)->first()->load(['shop']);
        } else {
            return abort(404);
        }

        //        dd($product->custom_attributes);
        if (empty($product->shop)) {
            /* TODO: Default value for products with no shops falls back to shop_id 1 */
            $product->shop = Shop::first();
        }

        /* TODO: add this eventually: && $product->published */
        if (!empty($product)) {
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
                ])
                ->log('viewed');
        }
        /* TODO: Make this optional (style1/style2/etc) per tenant/vendor */

        $template = 'product-single-1';

        return view('frontend.product.single.' . $template, compact('product'));
    }


    public function show_unlockable_content(Request $request, $slug)
    {
        /* TODO This is duplicate for consistent naming, let's refactor to better approach */
        if (Product::where('slug', $slug)->first()) {
            $product = Product::where('slug', $slug)->first()->load(['shop']);
        } else {
            return abort(404);
        }
        if(auth()->user()) {
            activity()
            ->performedOn($product)
            ->causedBy(auth()->user())
            ->withProperties([
                'action' => 'viewed',
                'action_title' => 'Viewed a purchased content',
            ])
            ->log('viewed');
        }


        return view('frontend.product.single.protected-content', compact('product'));
    }

    public function createProductCheckoutRedirect($id)
    {
        $product = Product::find($id);
        $qty = !empty(request()->qty ?? null) ? (int) request()->qty : 1;

        $link = StripeService::createCheckoutLink($product, $qty);

        return redirect($link);
    }
}
