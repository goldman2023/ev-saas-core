<?php

namespace App\View\Components\Dashboard\Widgets\Charts;

use App\Models\Activity;
use App\Models\Order;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Illuminate\View\Component;

class PieChart extends Component
{
    public $pieChartModel;
    public $lineChartModel;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $orders = Order::get();

        $pieChartModel = (new PieChartModel())

            ->addSlice('Open', 10, [])
            ->addSlice('Paid', 20, [])

            ->setType('donut')
            ->withOnSliceClickEvent('onSliceClick')
            //->withoutLegend()
            ->legendPositionBottom()
            ->legendHorizontallyAlignedCenter()
            ->setColors(['#b01a1b', '#d41b2c', '#ec3c3b', '#f66665']);

        $this->pieChartModel = $pieChartModel;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.widgets.charts.pie-chart');
    }
}
