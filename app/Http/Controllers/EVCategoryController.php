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

    // Frontend
    public function archiveByCategory(Request $request, $slug) {
        $selected_category = Categories::getAll(true)->get(Categories::getCategorySlugFromRoute($slug));

        // TODO: Get content types based on page builder sections added here
        $products = $selected_category->products()->orderBy('created_at', 'DESC')->paginate(10);
        $shops = $selected_category->shops()->orderBy('created_at', 'DESC')->paginate(10);

        return view('frontend.categories.archive', compact('selected_category', 'products', 'shops'));
    }
}
