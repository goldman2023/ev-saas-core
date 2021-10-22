<?php

namespace App\View\Components\Default\Contacts\Sections;

use Illuminate\View\Component;

class ContactFormWithMap extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

     public $map = false;
     public $address = '';
     public $form = 'email-form';
    public function __construct($address="", $map = false, $form = 'email-form')
    {
        //
        $this->map = $map;
        $this->address = $address;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.default.contacts.sections.contact-form-with-map');
    }
}
