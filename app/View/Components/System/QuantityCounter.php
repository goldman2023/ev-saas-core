<?php

namespace App\View\Components\System;

use Illuminate\View\Component;

class QuantityCounter extends Component
{
    public $id;

    public $wired;

    public $mini;

    public $parent;

    public $model;

    public $disabled;

    public $class;

    public $qtyField;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($parent = null, $model = null, $id = null, $wired = false, $mini = false, $class = '')
    {
        $this->id = $id;
        $this->parent = $parent;
        $this->model = $model;
        $this->wired = $wired;
        $this->mini = $mini;
        $this->disabled = ! $model->isInStock() && ! $model->allow_out_of_stock_purchases;
        $this->class = $class;

        $this->qtyField = 'qty';

        if(!empty($parent)) {
            // If parent model is present, it means that $model this counter is for is a child element of a prent and qty field is nested!
            $index_in_addons = $parent->purchased_addons->search(function ($item, $key) use ($model) {
                return $item->id === $model->id && $item instanceof $model;
            });

            $this->qtyField = 'addons['.$index_in_addons.'].qty';
        }
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
