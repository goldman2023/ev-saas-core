<?php

namespace App\View\Components\TailwindUi\Blog;

use App\View\Components\TailwindUi\WeComponent;
use Illuminate\View\Component;

class BlogPostCard extends WeComponent
{
    public $blogPost;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($blogPost)
    {
        $this->blogPost = $blogPost;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.blog.blog-post-card');
    }
}
