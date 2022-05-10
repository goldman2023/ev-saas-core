<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Categories;
use Cookie;
use Illuminate\Http\Request;
use MyShop;
use Permissions;
use Session;

class EVBlogPostController extends Controller
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
    public function blog_archive() {
        $blog_posts = BlogPost::whereNull('shop_id')->orwhere('shop_id', '=', 1)->published()->latest()->with(['authors'])
                        ->paginate(9)->withQueryString();

        return view('frontend.blog.blog-archive', compact('blog_posts'));
    }

    public function single(Request $request, $slug)
    {
        $blog_post = BlogPost::where('slug', $slug)->published()->with(['authors'])->first();
        $categories_idx = $blog_post->categories->pluck('id')->toArray();
        
        $related_blog_posts = BlogPost::whereHas('categories', function ($query) use($categories_idx) { 
            $query->whereIn('categories.id', $categories_idx);
        })->where('id', '!=', $blog_post->id)->published()->with(['authors'])->latest()->take(3)->get();

        $latest_blog_posts = BlogPost::where('id', '!=', $blog_post->id)->published()->with(['authors'])->latest()->take(3)->get();
        
        $authors = $blog_post->authors;

        if (! empty($blog_post)) {
            return view('frontend.blog.single.blog-post-single-1', compact('blog_post', 'authors', 'related_blog_posts', 'latest_blog_posts'));
        }

        abort(404);
    }
}
