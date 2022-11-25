<?php

namespace App\View\Components\Blog;

use App\Models\BlogPost;
use Illuminate\View\Component;

class TrendingArticles extends Component
{
    public $posts;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($posts = null)
    {
        //
        $this->posts = BlogPost::take(4)->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.blog.trending-articles');
    }
}
