<?php

namespace App\Http\Controllers;

use EVS;
use App\Models\Product;
use Auth;
use Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;

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

    /* TODO: Add middleware for owner */
    public function edit(Request $request, $slug) {
        $product = Product::where('slug', $slug)->first();

        if($product) {
            $product->convertUploadModelsToIDs();
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
        $category = Categories::getAll(true)->get(Categories::getCategorySlugFromRoute($slug));

        // TODO: Init Filters here

        // TODO: return view

        dd($category);

//        $selected_categories = Category::where('slug', $category_slug)->with('children')->get();
//        if (!empty($selected_categories) && $selected_categories->isNotEmpty()) {
//            return $this->search($request, $selected_categories);
//        }
//
//        abort(404); // TODO: Maybe a redirect to All Categories?
//        return null;
    }
}
