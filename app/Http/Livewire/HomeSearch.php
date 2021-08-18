<?php

namespace App\Http\Livewire;

use Livewire\Component;

class HomeSearch extends Component
{
    public $keywords = array();
    public $products = array();
    public $categories = array();
    public $events = array();
    public $keyword = '';

    public function render()
    {
        return view('livewire.home-search');
    }
}
