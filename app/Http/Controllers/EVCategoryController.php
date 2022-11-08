<?php

namespace App\Http\Controllers;

use Cookie;
use MyShop;
use Session;
use Categories;
use Permissions;
use App\Models\Shop;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodUniversal;

class EVCategoryController extends Controller
{
    public function index(Request $request)
    {
        $all_categories = Categories::getAll(true);

        return view('frontend.dashboard.categories.index', compact('all_categories'));
    }

    public function create(Request $request)
    {
        return view('frontend.dashboard.categories.create');
    }

    public function edit(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        return view('frontend.dashboard.categories.edit', compact('category'));
    }

    // Frontend
    public function archiveByCategory(Request $request, $slug)
    {
        $selected_category = Categories::getAll(true)->get(Categories::getCategorySlugFromRoute($slug));

        if(!empty($selected_category)) {
            // TODO: Get content types based on page builder sections added here
            $products = $selected_category->products()->orderBy('created_at', 'DESC')->paginate(10);
            $shops = $selected_category->shops()->orderBy('created_at', 'DESC')->paginate(10);
        } else {
            $products = Product::orderBy('created_at', 'DESC')->paginate(10);
            $shops = Shop::orderBy('created_at', 'DESC')->paginate(10);
        }
        

        return view('frontend.products.archive', compact('selected_category', 'products', 'shops'));
    }
}
