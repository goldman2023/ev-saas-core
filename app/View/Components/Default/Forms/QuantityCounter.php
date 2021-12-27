<?php

namespace App\View\Components\Default\Forms;

use Illuminate\View\Component;

class QuantityCounter extends Component
{
    public $id;
    public $wired;
    public $mini;
    public $model;
    public $disabled;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($model = null, $id = null, $wired = false, $mini = false)
    {
        $this->id = $id;
        $this->model = $model;
        $this->wired = $wired;
        $this->mini = $mini;
        $this->disabled = !$model->isInStock();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.forms.quantity-counter');
    }
}
