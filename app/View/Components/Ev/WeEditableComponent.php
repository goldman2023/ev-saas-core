<?php

namespace App\View\Components\Ev;

use Illuminate\View\Component;
// TODO: Check wtf is wrong with extending WeEditableComponent in resolving he component with app()!

abstract class WeEditableComponent extends Component
{
    abstract public function getEditableData();
    abstract public function setEditableData($data);
    abstract public function renderFieldComponent();
}