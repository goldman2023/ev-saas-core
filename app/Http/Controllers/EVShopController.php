<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use MyShop;
use Illuminate\Http\Request;
use Permissions;
use Session;
use Cookie;
use Categories;
use App\Models\Shop;

class EVShopController extends Controller
{
    /**
     * Shop Frontend routes
     */
    public function single(Request $request, $slug)
    {
        // TODO: Cleanup old active commerce code!
        $shop = Shop::where('slug', $slug)->first();
        if(empty($shop)) {
            return abort(404);
        }

        activity()
            ->performedOn($shop)
            ->causedBy(auth()->user())
            ->withProperties([
                'action' => 'viewed',
                'action_title' => 'viewed a shop',
                ])
            ->log('viewed');




        /* TODO: Shop shop page only after veiriication
            - verification_status column on $seller does not exists,
            what is replacement?
            */
        return view('frontend.shop.single', compact('shop'));
    }

    /**
     * Shop Dashboard routes
     */
    public function index(Request $request)
    {
        $blog_posts = BlogPost::all();
        return view('frontend.dashboard.blog-posts.index', compact('blog_posts'));
    }

    public function create(Request $request)
    {
        return view('frontend.dashboard.blog-posts.create');
    }

    public function edit(Request $request, $id)
    {
        $blog_post = BlogPost::findOrFail($id);

        return view('frontend.dashboard.blog-posts.edit', compact('blog_post'));
    }
}
