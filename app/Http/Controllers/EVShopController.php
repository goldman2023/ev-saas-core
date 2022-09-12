<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Shop;
use Categories;
use Cookie;
use Illuminate\Http\Request;
use MyShop;
use Permissions;
use Session;

class EVShopController extends Controller
{
    /**
     * Shop Frontend routes
     */
    public function single(Request $request, $slug)
    {
        // TODO: Cleanup old active commerce code!
        $shop = Shop::where('slug', $slug)->first();
        if (empty($shop)) {
            return abort(404);
        }

        if(auth()->user()) {
            $user = auth()->user();

            activity()
            ->performedOn($shop)
            ->causedBy($user)
            ->withProperties([
                'action' => 'viewed',
                'action_title' => 'viewed a shop',
            ])
            ->log('viewed');
        } else {
            $user = null;
        }



        /* TODO: Shop shop page only after veiriication
            - verification_status column on $seller does not exists,
            what is replacement?
            */
        return view('frontend.shop.shop-single', compact('shop', 'user'));
    }

    /**
     * Shop Dashboard routes
     */
    // TODO: Fix routing and create Shops archive page for admins in dashboard
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

    // API Routes
    public function api_search_shops(Request $request)
    {
        if(auth()->user()->isAdmin()) {
            $q = $request->q;

            $results = Shop::search($q)->get();

            // TODO: Return this as an API RESOURCE!

            return response()->json([
                'status' => 'success',
                'results' => $results
            ]);
        }

        throw new WeAPIException(message: translate('Cannot search shops if not admin or moderator'), type: 'WeApiException', code: 403);
    }
}
