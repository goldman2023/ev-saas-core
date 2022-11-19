<?php

namespace App\View\Components\Dashboard\Orders;

use Illuminate\View\Component;

class OrderDocumentModal extends Component
{
    public $documentType;
    public $document;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($document)
    {
        //
        $this->document = $document;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dashboard.orders.order-document-modal');
    }
}
