<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class EVProductController extends Controller
{
    //
    public function index(Request $request) {
        $products = Auth::user()->products()->orderBy('created_at','desc')->get();

        return view('frontend.user.crud.products.index')->with('products', $products);
    }

    public function create(Request $request) {
        return view('frontend.user.crud.products.create');
    }

    public function edit(Request $request, $slug) {
        $product = Auth::user()->products()->where('slug', $slug)->first();

        return view('frontend.user.crud.products.edit')->with('product', $product);
    }
}
