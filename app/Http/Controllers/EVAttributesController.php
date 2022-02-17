<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use MyShop;
use Illuminate\Http\Request;
use Permissions;
use Session;
use Cookie;
use Categories;

class EVAttributesController extends Controller
{
    public function index(Request $request, $content = null) {
        if(empty($content))
            abort(404);

        $content = base64_decode($content);

        $attributes = Attribute::where('content_type', $content)->get();
 
        return view('frontend.dashboard.attributes.index', compact('attributes'));
    }

    // public function create(Request $request) {
    //     return view('frontend.dashboard.blog-posts.create');
    // }

    public function edit(Request $request, $id) {
        $attribute = Attribute::findOrFail($id);

        return view('frontend.dashboard.attributes.edit', compact('attribute'));
    }

}
