<?php

namespace App\View\Components\TailwindUi\Blog;

use App\View\Components\TailwindUi\WeComponent;
use Illuminate\View\Component;

class BlogPostCard extends WeComponent
{
    public $blogPost;
    public $template;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($blogPost, $template = null)
    {
        $this->blogPost = $blogPost;
        $this->template = $template;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if(!empty($this->template)) {
            return view('components.tailwind-ui.blog.blog-post-card-'.$this->template);
        } else {
            return view('components.tailwind-ui.blog.blog-post-card');
        }
    }
}
