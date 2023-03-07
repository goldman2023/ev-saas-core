<?php

namespace App\View\Components\Wef;

use Illuminate\View\Component;

class Field extends Component
{
    public $wefId;
    public $subject;
    public $key;
    public $setType;
    public $getType;
    public $formType;
    public $customProperties;
    public $label;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($subject, $key, $label,  $setType = 'string', $getType = 'string', $formType = 'plain_text', $customProperties = [])
    {
        //
        $this->key = $key;
        $this->label = $label;
        $this->subject = $subject;
        $this->wefId = 'wef-'.$this->subject->id.'-'.$this->key;
        $this->setType = $setType;
        $this->getType = $getType;
        $this->formType = $formType;
        $this->customProperties = $customProperties;
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
