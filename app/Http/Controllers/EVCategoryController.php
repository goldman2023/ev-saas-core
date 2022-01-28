<?php

namespace App\Http\Controllers;

use App\Models\User;
use MyShop;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodUniversal;
use Illuminate\Http\Request;
use Permissions;
use Session;
use Cookie;
use Categories;

class EVCategoryController extends Controller
{
    public function index(Request $request) {
        $categories = Categories::getAll(true);
        return view('frontend.dashboard.categories.index', compact('categories'));
    }

    public function create(Request $request) {
        $categories = Categories::getAll(true);
        return view('frontend.dashboard.categories.index', compact('categories'));
    }
}
