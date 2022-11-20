<?php

namespace App\View\Components\Dashboard\Orders;

use Illuminate\Support\Facades\Storage;
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
            'id' => 1,
            'url' => storage_path() . '/documents/' . $order->id . '/certificate-'. $order->id .'.pdf',
            'title' => 'Contract',
        ];

        $this->documents['certificate'] = [
            'id' => 2,
            'url' => storage_path() . '/documents/' . $order->id . '/certificate-'. $order->id .'.pdf',
            'title' => 'Certificate',
        ];

        $this->documents['warrant'] = [
            'id' => 3,
            'url' => storage_path() . '/documents/' . $order->id . '/warrant-'. $order->id .'.pdf',
            'title' => 'Warrant',
        ];

        $this->documents['cash_check'] = [
            'id' => 4,
            'url' => storage_path() . '/documents/' . $order->id . '/cash-check-'. $order->id .'.pdf',
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
