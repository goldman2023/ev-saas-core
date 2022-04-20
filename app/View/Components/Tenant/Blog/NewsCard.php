<?php

namespace App\View\Components\Tenant\Blog;

use App\Models\Blog;
use Illuminate\View\Component;

class NewsCard extends Component
{
    public Blog $item;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Blog $item)
    {
        //
        $this->item = $item;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tenant.blog.news-card');
    }
}
