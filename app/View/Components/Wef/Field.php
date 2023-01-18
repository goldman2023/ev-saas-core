<?php

namespace App\View\Components\Wef;

use Illuminate\View\Component;

class Field extends Component
{
    public $wef_id;
    public $subject;
    public $key;
    public $type;
    public $form_type;
    public $label;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($subject, $key, $label,  $type = 'string', $form_type = 'plain_text')
    {
        //
        $this->key = $key;
        $this->label = $label;
        $this->subject = $subject;
        $this->wef_id = 'wef-order-'.$this->subject->id.'-'.$this->key;
        $this->type = $type;
        $this->form_type = $form_type;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.wef.field');
    }
}
