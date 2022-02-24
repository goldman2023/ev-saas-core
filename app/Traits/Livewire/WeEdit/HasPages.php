<?php

namespace App\Traits\Livewire\WeEdit;

use App\Models\Page;

trait HasPages
{
    public $current_page;
    public $all_pages;

    public function initializeHasPages()
    {
        $this->listeners = array_merge($this->listeners, [
            'currentPageChangeEvent' => 'changeCurrentPage',
        ]);
    }

    public function mountHasPages($page = null) {
        $this->current_page = $page;

        $this->all_pages = Page::all();
    }

    public function changeCurrentPage($page) {
        $this->current_page = $page;
    }
}