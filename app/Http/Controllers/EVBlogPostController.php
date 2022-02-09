<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use MyShop;
use Illuminate\Http\Request;
use Permissions;
use Session;
use Cookie;
use Categories;

class EVBlogPostController extends Controller
{
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
