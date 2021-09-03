<?php

namespace App\View\Components\EV;

use Illuminate\View\Component;

class DynamicImage extends Component
{
    public $src;
    public $show_input_field = false;
    public $href;
    public $widthInfos;
    public $dataSrcSet = '';

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($src, $href= "#", $widthInfos= null)
    {
        //
        $this->src = $src;
        $this->href = $href;
        $this->widthInfos = $widthInfos;
        if($this->widthInfos) {
            foreach($this->widthInfos as $widthInfo){
                $this->dataSrcSet .= uploaded_asset($src->value, $widthInfo[0]).' '.$widthInfo[1].', ';
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.dynamic-image');
    }
}
