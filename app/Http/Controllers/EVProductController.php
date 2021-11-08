<?php

namespace App\Http\Controllers;

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


    /* TODO: Add midleware for owner */
    public function edit(Request $request, $slug) {
        $product = Product::where('slug', $slug)->first();
        return view('frontend.user.crud.products.edit')->with('product', $product);
    }
}
