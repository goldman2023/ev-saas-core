<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\PageTranslation;


class PageController extends Controller
{

    public function privacy_policy_page() {
        return view('frontend.pages.privacy');

    }


    public function show_custom_page($slug)
    {
        $page = Page::where('slug', '=', $slug)->firstOrFail();
        $sections = $page->content;


        if ($page != null) {
            return view('frontend.custom_page', [
                'page' => $page,
                'sections' => $sections,
            ]);
        }

        return view('frontend.pages.' . $slug);
    }
}
