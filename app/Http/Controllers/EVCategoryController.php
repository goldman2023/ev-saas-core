<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
        $all_categories = Categories::getAll(true);
        return view('frontend.dashboard.categories.index', compact('all_categories'));
    }

    public function create(Request $request) {
        return view('frontend.dashboard.categories.create');
    }

    public function edit(Request $request, $id) {
        $category = Category::findOrFail($id);

        return view('frontend.dashboard.categories.edit', compact('category'));
    }
}
