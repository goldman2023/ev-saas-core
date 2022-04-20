<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\SubSubCategory;
use Cookie;
use Illuminate\Http\Request;
use Session;

class EVCartController extends Controller
{
    public function index(Request $request)
    {
        return view('frontend.cart');
    }
}
