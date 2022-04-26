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
    public function single(Request $request, $slug)
    {
        $blog_post = BlogPost::where('slug', $slug)->first();

        if (! empty($blog_post)) {
            return view('frontend.blog.single.blog-post-single-1', compact('blog_post'));
        }

        abort(404);
    }
}
