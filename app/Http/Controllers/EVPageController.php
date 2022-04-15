<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\BlogPost;
use MyShop;
use Illuminate\Http\Request;
use Permissions;
use Session;
use Cookie;
use Categories;

class EVPageController extends Controller
{
    public function index(Request $request) {
        $pages = Page::all();
        return view('frontend.dashboard.pages.index', compact('pages'));
    }

    public function create(Request $request) {
        return view('frontend.dashboard.pages.create');
    }

    public function edit(Request $request, $id) {
        $page = Page::findOrFail($id);

        return view('frontend.dashboard.pages.edit', compact('page'));
    }

}
