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
    public function show(Request $request)
    {
        $preview = session('page_preview');

        if (empty($preview)) {
            $preview = Page::where('slug', 'home')->first()?->page_previews()->first()->toArray();
        }

        return view('we-edit.preview-show', compact('preview'));
    }
}
