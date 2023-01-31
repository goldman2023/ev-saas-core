<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Page;
use App\Models\PageTranslation;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function privacy_policy_page()
    {
        return view('frontend.pages.privacy');
    }

    public function show_custom_page(Request $request, $slug)
    {
        if(!$request->routeIs('custom-pages.show')) {
            return redirect()->route('custom-pages.show', $slug);
        }

        try {
            if (view('frontend.custom-pages.'.$slug)) {
                return view('frontend.custom-pages.'.$slug);
            }
        } catch (\Exception $e) {
            $page = Page::where('slug', '=', $slug)->first();

            if ($page != null) {
                $sections = $page->content;


                if(auth()->user()) {
                    activity()
                    ->performedOn($page)
                    ->causedBy(auth()->user())
                    ->withProperties([
                        'action' => 'viewed',
                        'action_title' => 'Viewed a page',
                    ])
                    ->log('viewed');
                }

                return view('frontend.custom_page', [
                    'page' => $page,
                    'sections' => $sections,
                ]);
            } else {
                /* Blog post redirect */
                // dd($slug);
                $blog_post = BlogPost::where('slug', $slug)->get();
                if($blog_post) {
                    return redirect(route('blog.post.single', $slug), 301);
                } else {
                    return abort(404);
                }

            }

            return view('frontend.pages.'.$slug);
        }
    }
}
