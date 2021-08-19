<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\Event;
use App\Models\Shop;
use Illuminate\Support\Facades\Log;

class HomeSearch extends Component
{
    public $keywords;
    public $products;
    public $categories;
    public $events;
    public $shops;
    public $query = '';
    public $isEmpty = true;
    public $tenant;

    public function mount()
    {
        $this->tenant = tenant();
    }

    public function render()
    {
        $this->keywords = array();
        $this->products = array();
        $this->categories = array();
        $this->events = array();
        $this->shops = array();

        if (trim($this->query) != '') {

            $products = Product::where('tags', 'like', '%' . $this->query . '%')->get();
            foreach ($products as $key => $product) {
                foreach (explode(',', $product->tags) as $key => $tag) {
                    if (stripos($tag, $this->query) !== false) {
                        if (sizeof($this->keywords) > 5) {
                            break;
                        } else {
                            if (!in_array(strtolower($tag), $this->keywords)) {
                                array_push($this->keywords, strtolower($tag));
                            }
                        }
                    }
                }
            }

            $this->products = $products->take(3);

            $this->categories = Category::where('name', 'like', '%' . $this->query . '%')->get()->take(3);

            $this->shops = Shop::where('name', 'like', '%' . $this->query . '%')->get()->take(3);

            $this->events = Event::where('title', 'like', '%' . $this->query . '%')->orWhere('description', 'like', '%' . $this->query . '%')->get()->take(3);

        }

        if (sizeof($this->keywords) > 0 || sizeof($this->categories) > 0 || sizeof($this->products) > 0 || sizeof($this->shops) > 0) {
            $this->isEmpty = false;
        }else {
            $this->isEmpty = true;
        }

        return view('livewire.home-search');
    }
}
