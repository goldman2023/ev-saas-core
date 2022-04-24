<?php

namespace App\View\Components\Default\KnowledgeBase;

use App\Models\User;
use Illuminate\View\Component;

class ArticleCard extends Component
{
    public $user;

    public $article;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        /* TODO: Make this dynamic */
        $this->user = User::find(1);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.knowledge-base.article-card');
    }
}
