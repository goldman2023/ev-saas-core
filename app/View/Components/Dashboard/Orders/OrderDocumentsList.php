<?php

namespace App\View\Components\Dashboard\Orders;

use Illuminate\View\Component;

class OrderDocumentsList extends Component
{
    public $order;
    public $documents;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        //
        $this->order = $order;

        $this->documents['contract'] = [
            'url' => '#',
            'title' => 'Contract',
        ];

        $this->documents['certificate'] = [
            'url' => '#',
            'title' => 'Certificate',
        ];

        $this->documents['warrant'] = [
            'url' => '#',
            'title' => 'Warrant',
        ];

        $this->documents['cash_check'] = [
            'url' => '#',
            'title' => 'Cash Check',
        ];

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.orders.order-documents-list');
    }
}
