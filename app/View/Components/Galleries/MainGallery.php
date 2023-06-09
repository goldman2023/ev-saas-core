<?php

namespace App\View\Components\Galleries;

use App\Facades\CartService;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\View\Component;
use Session;

class MainGallery extends Component
{
    public $model;

    public $class;

    public $imgClass;

    public $template;

    public $thumbnail;

    public $cover;

    public $gallery;

    public $showGallery;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model = null, $class = '', $imgClass = '', $template = 'product-gallery', $showGallery = false)
    {
        $this->model = $model;
        $this->class = $class;
        $this->imgClass = $imgClass;
        $this->template = $template;
        $this->thumbnail = $model->getThumbnail(['w' => 600]);
        $this->cover = $model->getCover(['w' => 600]);
        $this->gallery = $model->getGallery(['w' => 600]);
        $this->showGallery = $showGallery;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.galleries.'.$this->template);
    }
}
