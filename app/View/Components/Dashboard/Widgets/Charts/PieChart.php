<?php

namespace App\View\Components\Dashboard\Widgets\Charts;

use App\Models\Activity;
use App\Models\Order;
use App\Models\User;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Asantibanez\LivewireCharts\Models\PieChartModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class PieChart extends Component
{
    public $pieChartModel;
    public $lineChartModel;
    public $activityChartModel;
    public $userChartModel;
    public $activityCount;
    public $ordersCount;
    public $newUserCount;
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

        $data = Cache::remember('dashboard_orders_stats', 600, function () use ($startDate, $endDate) {
            return Order::whereBetween('created_at', [$startDate, $endDate])
            ->select(\DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), \DB::raw('count(*) as orders, DATE_FORMAT(created_at, "%Y-%m-%d") as order_date'))
            ->groupBy('DATE_FORMAT(created_at, "%Y-%m-%d")')
            ->get();
        });

        $dataActivity = Activity::whereBetween('created_at', [$startDate, $endDate])
            ->select(\DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), \DB::raw('count(*) as orders, DATE_FORMAT(created_at, "%Y-%m-%d") as activity_date'))
            ->groupBy('DATE_FORMAT(created_at, "%Y-%m-%d")')
            ->get();

        $dataUsers = User::whereBetween('created_at', [$startDate, $endDate])
            ->select(\DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), \DB::raw('count(*) as orders, DATE_FORMAT(created_at, "%Y-%m-%d") as user_date'))
            ->groupBy('DATE_FORMAT(created_at, "%Y-%m-%d")')
            ->get();





        $lineChartModel = (new LineChartModel());
        // $lineChartModel->setColors(['#8bc43e']);
        // $lineChartModel->setSmoothCurve();
        $total = 0;
        $lineChartModel->addPoint(0, 0);

        foreach ($data as $key => $item) {
            $total = $item->orders;
            $lineChartModel->addPoint($item->order_date, $total);
        }
        // $lineChartModel->addPoint(7, 10);
        // $lineChartModel->addPoint(8, 20);
        // $lineChartModel->addPoint(9, 30);

        $this->lineChartModel = $lineChartModel;

        $this->activityChartModel = (new LineChartModel());
        $this->activityChartModel->setSmoothCurve();
        $total = 0;

        foreach ($dataActivity as $key => $item) {
            $total += $item->orders;
            $this->activityChartModel->addPoint($item->activity_date, $total);
        }

        $this->newUserCount = $dataUsers->count();

        $this->userChartModel = (new LineChartModel());
        $total = 0;

        foreach ($dataUsers as $key => $item) {
            $total = $item->orders;
            $this->userChartModel->addPoint($item->user_date, $total);
        }

        $this->activityCount = $dataActivity->count();
        $this->ordersCount = $data->count();
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
