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
    public function single(Request $request, $slug) {
        // TODO: Cleanup old active commerce code!
        $shop = Shop::where('slug', $slug)->first();

        if (!empty($shop)) {
            $seller = $shop->seller();

            if(auth()->check()) {
                $user = auth()->user();

            } else {
                $user = null;
            }

            activity()
                ->performedOn($shop)
                ->causedBy($user)
                ->withProperties(['action' => 'viewed'])
                ->log('User viewed a company page');

            // Seo integration with Schema.org
            if (get_setting('enable_seo_company') == "on") {
                seo()->addSchema($seller->get_schema());
            }

            /* TODO: Shop shop page only after veiriication
            - verification_status column on $seller does not exists,
            what is replacement?
            */
                return view('frontend.company.profile', compact('shop', 'seller'));

            // Show company profile only for company owner user
            if ($seller->user->id === auth()->user()->id ?? null) {
                return view('frontend.company.profile', compact('shop', 'seller'));
            }

            // Show company profile without verification tag to other people
            return view('frontend.seller_shop_without_verification', compact('shop', 'seller'));
        }

        abort(404);
    }

    /**
     * Shop Dashboard routes
     */
    public function index(Request $request) {
        $blog_posts = BlogPost::all();
        return view('frontend.dashboard.blog-posts.index', compact('blog_posts'));
    }

    public function create(Request $request) {
        return view('frontend.dashboard.blog-posts.create');
    }

    public function edit(Request $request, $id) {
        $blog_post = BlogPost::findOrFail($id);

        return view('frontend.dashboard.blog-posts.edit', compact('blog_post'));
    }

}
