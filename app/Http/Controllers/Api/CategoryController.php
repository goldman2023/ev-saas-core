<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CategoryCollection;
use App\Models\BusinessSetting;
use App\Models\Category;

class CategoryController extends Controller
{

    public function index()
    {
        return new CategoryCollection(Category::where('level', 0)->get());
    }

    public function featured()
    {
        return new CategoryCollection(Category::where('featured', 1)->get());
    }

    public function home()
    {
        $homepageCategories = BusinessSetting::where('type', 'home_categories')->first();
        $homepageCategories = json_decode($homepageCategories->value);
        return new CategoryCollection(Category::whereIn('id', $homepageCategories)->get());
    }
}
