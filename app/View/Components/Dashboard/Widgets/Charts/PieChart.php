<?php

namespace App\View\Components\Dashboard\Widgets\Charts;

use App\Models\Activity;
use App\Models\Order;
use App\Models\User;
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

        $startDate = \Carbon::createFromFormat('Y-m-d', '2022-01-01');
        $endDate = \Carbon::createFromFormat('Y-m-d', '2023-01-30');

        $data = User::whereBetween('created_at', [$startDate, $endDate])
            ->select(\DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), \DB::raw('count(*) as users'))
            ->groupBy('DATE_FORMAT(created_at, "%Y-%m-%d")')
            ->get();





        $lineChartModel = (new LineChartModel());
        $total = 0;
        foreach($data as $key => $item) {
            $total += $item->users;
            $lineChartModel->addPoint($key, $total);
        }
        // $lineChartModel->addPoint(7, 10);
        // $lineChartModel->addPoint(8, 20);
        // $lineChartModel->addPoint(9, 30);

        $this->lineChartModel = $lineChartModel;
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
