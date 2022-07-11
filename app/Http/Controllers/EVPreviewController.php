<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\Page;
use Categories;
use Cookie;
use Illuminate\Http\Request;
use MyShop;
use Permissions;
use Session;

class EVPreviewController extends Controller
{
    public function show(Request $request, $slug)
    {
            $preview = Page::where('slug', $slug)->first()?->page_previews()->first()->toArray();
        $sections = $preview['content'];


        return view('we-edit.preview-show', compact('preview', 'sections'));
    }
}
