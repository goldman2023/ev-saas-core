<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageTranslation;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function privacy_policy_page()
    {
        return view('frontend.pages.privacy');
    }

    public function show_custom_page($slug)
    {
        try {
            if (view('frontend.custom-pages.'.$slug)) {
                return view('frontend.custom-pages.'.$slug);
            }
        } catch (\Exception $e) {
            $page = Page::where('slug', '=', $slug)->firstOrFail();
            $sections = $page->content;

            if ($page != null) {
                return view('frontend.custom_page', [
                    'page' => $page,
                    'sections' => $sections,
                ]);
            }

            return view('frontend.pages.'.$slug);
        }
    }
}
