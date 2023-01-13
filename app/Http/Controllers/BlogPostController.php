<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\SocialPost;
use App\Models\Category;
use Categories;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use MyShop;
use Permissions;
use Session;

class BlogPostController extends Controller
{
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

    // FRONTEND
    public function blog_archive()
    {
        $blog_posts = BlogPost::whereNull('shop_id')->orwhere('shop_id', '=', 1)->published()->latest()->with(['authors'])
            ->paginate(9)->withQueryString();

        return view('frontend.blog.blog-archive', compact('blog_posts'));
    }

    public function blog_archive_by_category($category_slug = null)
    {
        if (!empty($category_slug)) {
            $category = Category::where('slug', $category_slug)->first();

            if (!empty($category)) {
                $categories_ids = $category->descendantsAndSelf()->select('id')->get()->pluck('id')->toArray(); // Get all descedants and desired category's IDs

                $blog_posts = BlogPost::whereNull('shop_id')->orwhere('shop_id', '=', 1)->whereHas('categories', function ($query) use ($categories_ids) {
                    $query->whereIn('category_relationships.category_id', $categories_ids);
                })
                    ->published()->latest()->with(['authors'])
                    ->paginate(9)->withQueryString();

                return view('frontend.blog.blog-archive', compact('blog_posts', 'category'));
            }
        }

        return $this->blog_archive();
    }

    public function single(Request $request, $slug,)
    {
        // TODO: Think of a way to somehow move the access logic into a trait (so it can be overwritten on demand for some models) and make into a local scope
        // reason for this is that we can just use local scope (->restrictAccess()) instead of always writing: ->when()->when()->when() bla bla!
        $blog_post = Cache::remember('blog_post_cache_' . $slug, 600, function () use ($slug) {
            return BlogPost::where('slug', $slug)->with(['authors', 'shop'])
                ->when(!(auth()->user()?->isAdmin() ?? false), fn ($query) => $query->published())
                ->first();
        });

        if ($blog_post) {
            $categories_idx = $blog_post->categories->pluck('id')->toArray();
            $related_blog_posts = Cache::remember('related_blog_posts_' . $slug, 600, function () use ($categories_idx, $blog_post) {
                return  BlogPost::whereHas('categories', function ($query) use ($categories_idx) {
                    $query->whereIn('categories.id', $categories_idx);
                })->where('id', '!=', $blog_post->id)->published()->with(['authors'])->latest()->take(3)->get();
            });
        }

        if ($blog_post) {

            $latest_blog_posts = Cache::remember('latest_blog_posts_' . $slug, 600, function () use ($blog_post) {
                return BlogPost::where('id', '!=', $blog_post->id)->published()->with(['authors'])->latest()->take(3)->get();
            });


            $authors = $blog_post->authors;
            $shop = $blog_post->shop;
        } else {
            abort(404);
        }
        // /* Prototype for lazy loading images */
        $content = $blog_post->content;
        // $html = Cache::remember('blog_post_cache_' . $slug . '_html', 600, function () use ($content) {
        //      return $html;
        // });

        $html = preg_replace('/<img(.+?)src="(.+?)"(.+?)>/i', '<img$1 loading="lazy" src="$2"$3>', $content);
        $html = preg_replace('/<img(.+?)srcset="(.+?)"(.+?)>/i', '<img$1 data-srcset="$2"$3>', $html);
        $html = preg_replace('/<iframe(.+?)src="(.+?)"(.+?)>/i', '<iframe$1 loading="lazy" src="$2"$3>', $content);



        if (!empty($blog_post)) {
            return view('frontend.blog.blog-post-single', compact('blog_post', 'authors', 'shop', 'related_blog_posts', 'latest_blog_posts', 'html'));
        }

        abort(404);
    }

    public function social_post_single(Request $request, $id)
    {
        $social_post = SocialPost::find($id);
        $author = $social_post->user;

        $latest_social_posts = SocialPost::where('id', '!=', $social_post->id)->published()->with(['user'])->latest()->take(3)->get();

        if (!empty($social_post)) {
            return view('frontend.blog.social-post-single', compact('social_post', 'author', 'latest_social_posts'));
        }

        abort(404);
    }
}
