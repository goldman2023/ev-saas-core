<?php

namespace App\View\Components\EV\Form;

use Illuminate\View\Component;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class ProductVariationsDatatable extends DataTableComponent
{
    public $class;
    public $id;
    public $tableClass;
    public $variationAttributes;
    public $options;
    public $errorBagName;
    public $valueProperty;
    public $labelProperty;
    public $wireType;
    public $columns;
    public $variations;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($variationAttributes = [], $columns = [], $variations = [], $options = [], $valueProperty = null, $labelProperty = null, $class = '', $tableClass = '', $id = '', $errorBagName = null, $wireType = 'defer')
    {
        $this->variationAttributes = $variationAttributes;
        $this->valueProperty = $valueProperty;
        $this->labelProperty = $labelProperty;
        $this->class = $class;
        $this->tableClass = $tableClass;
        $this->id = $id;
        $this->options = $options;
        $this->wireType = $wireType;
        $this->errorBagName = $errorBagName;
        $this->variations = $variations;

        $this->columns = array_merge(['#', 'Name'], array_column($variationAttributes->toArray(), 'name'), ['']);
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.form.variations-datatable');
    }
}
