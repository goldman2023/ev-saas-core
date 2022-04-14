<?php

namespace App\View\Components\WeEdit\Modals;

use Illuminate\View\Component;

class ExportJsonModal extends Component
{
    public $json;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($json = '')
    {
        $this->json = $json;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.we-edit.modals.export-json-modal');
    }
}
