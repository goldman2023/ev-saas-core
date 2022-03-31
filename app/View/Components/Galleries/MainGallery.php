<?php

namespace App\View\Components\Galleries;

use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\View\Component;
use App\Facades\CartService;
use Session;

class MainGallery extends Component
{
    public $model;
    public $class;
    public $template;
    public $thumbnail;
    public $cover;
    public $gallery;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model = null, $class = '', $template = 'product-gallery')
    {
        $this->model = $model;
        $this->class = $class;
        $this->template = $template;
        $this->thumbnail = $model->getThumbnail(['w' => 600]);
        $this->cover = $model->getCover(['w' => 600]);
        $this->gallery = $model->getGallery(['w' => 600]);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render() {
        return view('components.tailwind-ui.galleries.' . $this->template);
    }
}
