<?php

namespace App\View\Components\TailwindUi\Sections\Marketing\BlogArchives;

use Illuminate\View\Component;

class BlogArchive01 extends BlogArchive
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.sections.marketing.blog-archives.blog-archive01')->with([
            'blog_posts' => \App\Models\BlogPost::published()->orderBy('created_at', 'desc')->with(['authors'])->paginate(9)->withQueryString(),
        ]);
    }
}
