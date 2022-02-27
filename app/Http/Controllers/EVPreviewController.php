<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\Page;
use MyShop;
use Illuminate\Http\Request;
use Permissions;
use Session;
use Cookie;
use Categories;

class EVPreviewController extends Controller
{
    public function show(Request $request) {
        $preview = session('page_preview');

        if(empty($preview)) {
            $preview = Page::where('slug', 'home')->first()->toArray();
        }
        
        return view('we-edit.preview-show', compact('preview'));
    }

}
