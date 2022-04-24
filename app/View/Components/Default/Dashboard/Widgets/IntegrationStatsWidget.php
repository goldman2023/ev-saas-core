<?php

namespace App\View\Components\Default\Dashboard\Widgets;

use Illuminate\View\Component;

class IntegrationStatsWidget extends Component
{
    public $type;

    public $img;

    public $url;

    public $title;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($img, $url, $title = 'Integration', $type = 'analytics')
    {
        //
        $this->type = $type;

        $this->title = $title;

        $this->img = $img;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.dashboard.widgets.integration-stats-widget');
    }
}
