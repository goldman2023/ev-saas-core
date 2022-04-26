<?php

namespace App\View\Components\Default\Blog\Single;

use App\Models\BlogPost;
use Illuminate\View\Component;

class Card extends Component
{
    public BlogPost $item;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(BlogPost $item)
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
        return view('components.default.blog.single.card');
    }
}
