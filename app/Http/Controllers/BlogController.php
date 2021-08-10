<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\LoggingTrait;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    use LoggingTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search = null;
        $blogs = Blog::orderBy('created_at', 'desc');

        if ($request->search != null) {
            $blogs = $blogs->where('title', 'like', '%' . $request->search . '%');
            $sort_search = $request->search;
        }


        $blogs = $blogs->paginate(15);
        return view('backend.blog_system.blog.index', compact('blogs', 'sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $blog_categories = Category::all();
        return view('backend.blog_system.blog.create', compact('blog_categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'category_id' => 'required',
            'title' => 'required|max:255',
        ]);

        $blog = new Blog;

        $blog->category_id = $request->category_id;
        $blog->title = $request->title;
        $blog->banner = $request->banner;
        $blog->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        $blog->short_description = $request->short_description;
        $blog->description = $request->description;
        // remove all html tags including <br> cause it's formatting description as html check /frontend/blog/detail.blade.php
        // {{ !! $blog->description !! }}
        $blog->estimated_time = $this->calculate_read_estimation(strip_tags($request->description));
        $blog->meta_title = $request->meta_title;
        $blog->meta_img = $request->meta_img;
        $blog->meta_description = $request->meta_description;
        $blog->meta_keywords = $request->meta_keywords;
        $blog->user_id = auth()->user()->id;
        $blog->save();
        $this->log($blog,"created a news post");
        flash(translate('Blog post has been created successfully'))->success();
        return redirect()->route('admin.blog.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blog::find($id);
        $blog_categories = Category::all();
        return view('backend.blog_system.blog.edit', compact('blog', 'blog_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'title' => 'required|max:255',
        ]);

        $blog = Blog::find($id);

        $blog->category_id = $request->category_id;
        $blog->title = $request->title;
        $blog->banner = $request->banner;
        $blog->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->slug));
        $blog->estimated_time = $this->calculate_read_estimation(strip_tags($request->description));
        $blog->short_description = $request->short_description;
        $blog->description = $request->description;
        $blog->meta_title = $request->meta_title;
        $blog->meta_img = $request->meta_img;
        $blog->meta_description = $request->meta_description;
        $blog->meta_keywords = $request->meta_keywords;
        $blog->save();
        $this->log($blog,"updated a news post");
        flash(translate('Blog post has been updated successfully'))->success();
        return redirect()->route('admin.blog.index');
    }

    public function change_status(Request $request)
    {
        $blog = Blog::find($request->id);
        $blog->status = $request->status;

        $blog->save();
        return 1;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $blog = Blog::find($id);
        $this->log($blog,"Blog post is removed.");
        $blog->delete();

        return back();
    }


    public function all_blog()
    {
        $blogs = Blog::where('status', 1)->orderBy('created_at', 'desc')->paginate(12);
        $categories = $categories = Category::where('level', 0)->orderBy('order_level', 'desc')->get();
        return view("frontend.blog.listing", compact('blogs', 'categories'));
    }

    public function blog_details($slug)
    {

        $blog = Blog::with('visit')->where('slug', $slug)->first();

        if (\auth()->user()) {
            visits($blog, "auth")->increment();
            $this->log($blog,"User viewed this news post ");
        } else {
            visits($blog)->increment();
        }
        return view("frontend.blog.show", compact('blog'));
    }

    public function blog_category($slug)
    {
        $category = Category::where('slug', $slug)->first();
        return view("frontend.blog.category", compact('category'));
    }

    public function calculate_read_estimation($text)
    {
        $words = explode(" ", $text);
        // average reading speed 200wpm http://ezinearticles.com/?What-is-the-Average-Reading-Speed-and-the-Best-Rate-of-Reading?&id=2298503
        return ceil(count($words) / 200);

    }
}
