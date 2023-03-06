<?php

namespace App\Http\Controllers;

use WE;
use Auth;
use Stripe;
use Categories;
use App\Models\Shop;
use App\Facades\MyShop;
use App\Models\Product;
use App\Models\ProductAddon;
use Illuminate\Http\Request;
use App\Enums\CourseItemTypes;
use App\Enums\ProductTypeEnum;
use App\Facades\StripeService;
use App\Exceptions\WeAPIException;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;
use Laravel\Nova\Notifications\NovaNotification;
use App\Http\Livewire\Dashboard\Forms\Orders\OrderForm;

class ProductAddonController extends Controller
{
    //
    public function index(Request $request)
    {
        if (Auth::user()->user_type == 'admin') {
            $product_addons_count = ProductAddon::orderBy('created_at', 'desc')->count();
        } else {
            $product_addons_count = Auth::user()->product_addons()->count();
        }


        return view('frontend.dashboard.product-addons.index', compact('product_addons_count'));
    }

    public function create(Request $request)
    {
        /* Check if user has shop */
        if (!MyShop::getShop()) {
            /* If not, redirect to shop creation */
            return redirect()->route('onboarding.step3');
        }

        return view('frontend.dashboard.product-addons.create');
    }

    /* TODO: Add middleware for owner */
    public function edit(Request $request, $id)
    {
        $productAddon = ProductAddon::findOrFail($id);

        return view('frontend.dashboard.product-addons.edit')->with('productAddon', $productAddon);
    }

    public function edit_stocks(Request $request, $id)
    {
        $productAddon = ProductAddon::findOrFail($id);

        if ($productAddon) {
            $productAddon->convertUploadModelsToIDs();
        }

        return view('frontend.dashboard.product-addons.stocks')
            ->with('productAddon', $productAddon);
            // ->with('variations_attributes', $productAddon->variant_attributes());
    }

    public function details(Request $request, $id)
    {
        $product = ProductAddon::findOrFail($id);

        return view('frontend.dashboard.product-addons.details')->with('product', $product);
    }

    // API routes
    public function api_search_product_addons(Request $request) {
        // if(auth()->user()->isAdmin()) {
            $q = $request->q;

            $results = ProductAddon::published()->search($q)->get();

            foreach($results as $index => $product_addon) {
                $results_array[] = serialize_with_form_friendly_custom_attributes($product_addon);
            }

            // TODO: Return this as an API RESOURCE!
            return response()->json([
                'status' => 'success',
                'results' => $results_array
            ]);
        // }

        // throw new WeAPIException(message: translate('Cannot search product addons if not admin or moderator'), type: 'WeApiException', code: 403);
    }

}
