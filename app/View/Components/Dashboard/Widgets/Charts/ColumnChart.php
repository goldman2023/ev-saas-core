<?php

namespace App\View\Components\Dashboard\Widgets\Charts;

use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Illuminate\View\Component;

class ColumnChart extends Component
{

    public $columnChartModel;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //

        $this->columnChartModel =
            (new ColumnChartModel())
            ->setTitle('Users')
            ->setAnimated(false)
            ->addColumn('Food', 100, '#f6ad55')
            ->addColumn('Shopping', 200, '#fc8181')
            ->addColumn('Travel', 300, '#90cdf4');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.widgets.charts.column-chart');
    }
}
