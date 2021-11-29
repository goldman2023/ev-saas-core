<?php

namespace App\Http\Controllers;

use App\Facades\EVS;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;

class EVProductController extends Controller
{
    //
    public function index(Request $request) {
        $products = Auth::user()->products()->orderBy('created_at','desc')->paginate(20);

        return view('frontend.user.crud.products.index')->with('products', $products);
    }

    public function create(Request $request) {
        return view('frontend.user.crud.products.create');
    }

    /* TODO: Add middleware for owner */
    public function edit(Request $request, $slug) {
        $product = Product::where('slug', $slug)->first();

        if($product) {
            $product->convertUploadModelsToIDs();
        }

        return view('frontend.user.crud.products.edit')->with('product', $product);
    }

    public function edit_stocks(Request $request, $slug) {
        $product = Product::where('slug', $slug)->first();

        if($product) {
            $product->convertUploadModelsToIDs();
        }

        return view('frontend.user.crud.products.stocks')
            ->with('product', $product)
            ->with('variations_attributes', $product->variant_attributes());
    }

    public function edit_variations(Request $request, $slug) {
        $productVariationsDatatableClass = 'ev-product-variations-component';

        $product = Product::where('slug', $slug)->first();

        if($product) {
            $product->convertUploadModelsToIDs();
        }

        return view('frontend.user.crud.products.variations')
        ->with('product', $product)
        ->with('variations_attributes', $product->variant_attributes())
        ->with('productVariationsDatatableClass', $productVariationsDatatableClass);
    }

    public function product_details(Request $request, $slug) {
        $product = Product::where('slug', $slug)->first();

        if($product) {
            $product->convertUploadModelsToIDs();
        }

        return view('frontend.user.crud.products.details')->with('product', $product);
    }
}
