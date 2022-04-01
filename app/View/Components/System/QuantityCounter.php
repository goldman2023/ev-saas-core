<?php

namespace App\View\Components\System;

use Illuminate\View\Component;

class QuantityCounter extends Component
{
    public $id;
    public $wired;
    public $mini;
    public $model;
    public $disabled;
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model = null, $id = null, $wired = false, $mini = false, $class = "")
    {
        $this->id = $id;
        $this->model = $model;
        $this->wired = $wired;
        $this->mini = $mini;
        $this->disabled = !$model->isInStock();
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.tailwind-ui.system.quantity-counter');
    }
}
