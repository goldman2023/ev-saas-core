<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SubSubCategory;
use App\Models\Category;
use Session;
use App\Models\Color;
use Cookie;

class EVCartController extends Controller
{

    public function index(Request $request)
    {
        return view('frontend.cart');
    }
}
