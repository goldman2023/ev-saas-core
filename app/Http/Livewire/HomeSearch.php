<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Event;
use App\Models\Product;
use App\Models\Shop;
use Livewire\Component;

class HomeSearch extends Component
{
    public $keywords = [];

    public $products = [];

    public $categories = [];

    public $events = [];

    public $shops = [];

    public $query = '';

    public $isEmpty = false;    // Check empty string show/hide

    public $isOpen = false;     // Check search result show/hide

    public $isLoader = false;   // Check loader show/hide

    public $tenant;

    public function mount()
    {
        $this->tenant = tenant();
    }

    public function search()
    {
        $this->reset(['keywords', 'products', 'categories', 'events', 'shops', 'isOpen', 'isLoader', 'isEmpty']);

        if (trim($this->query) != '') {
            $this->isOpen = true;
            $products = Product::where('tags', 'like', '%'.$this->query.'%')->get();
            foreach ($products as $key => $product) {
                foreach (explode(',', $product->tags) as $key => $tag) {
                    if (stripos($tag, $this->query) !== false) {
                        if (count($this->keywords) > 5) {
                            break;
                        } else {
                            if (! in_array(strtolower($tag), $this->keywords)) {
                                array_push($this->keywords, strtolower($tag));
                            }
                        }
                    }
                }
            }

            $this->products = $products->take(3);
            $this->categories = Category::where('name', 'like', '%'.$this->query.'%')->get()->take(3);
            $this->shops = Shop::where('name', 'like', '%'.$this->query.'%')->get()->take(3);
            $this->events = Event::where('title', 'like', '%'.$this->query.'%')->orWhere('description', 'like', '%'.$this->query.'%')->get()->take(3);
        }

        if (count($this->keywords) == 0 && count($this->categories) == 0 && count($this->products) == 0 && count($this->shops) == 0 && trim($this->query) != '') {
            $this->isEmpty = true;
        }
    }

    public function render()
    {
        $this->search();

        return view('livewire.home-search');
    }
}
