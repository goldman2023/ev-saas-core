<?php

namespace App\Http\Controllers;

use App\Enums\ContentTypeEnum;
use App\Models\Attribute;
use Categories;
use Cookie;
use Illuminate\Http\Request;
use MyShop;
use Permissions;
use Session;

class EVAttributesController extends Controller
{
    public function index(Request $request, $content_type = null)
    {
        if (empty($content_type)) {
            abort(404);
        }

        $content_type = base64_decode($content_type);

        $attributes = Attribute::where('content_type', $content_type)->get();

        return view('frontend.dashboard.attributes.index', compact('attributes', 'content_type'));
    }

    public function create(Request $request, $content_type = null)
    {
        $content_type = base64_decode($content_type);

        if (collect(ContentTypeEnum::values())->search($content_type) === false) {
            abort(404);
        }

        return view('frontend.dashboard.attributes.create', compact('content_type'));
    }

    public function edit(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);

        return view('frontend.dashboard.attributes.edit', compact('attribute'));
    }
}
