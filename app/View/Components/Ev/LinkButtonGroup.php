<?php

namespace App\View\Components\Ev;

use App\Models\Models\EVLabel;
use Illuminate\View\Component;

// class LinkButtonGroup extends WeEditableComponent
class LinkButtonGroup extends Component
{
    public $buttonGroup;
    public $class;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($buttonGroup = [], $class= '')
    {
        $this->buttonGroup = $buttonGroup;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.link-button-group');
    }

    // WeEdit Builder
    public function getEditableData() {
       
        if(is_array($this->buttonGroup)) {
            if(empty($this->buttonGroup)) {
                $this->buttonGroup = [
                    LinkButton::getDefaultData() // Set button group to default to one button in array
                ];
            } else {
                foreach($this->buttonGroup as $key => $button) {
                    
                    // $this->buttonGroup[$key] = array_merge(LinkButton::getDefaultData(), $button);
                  
                    $this->buttonGroup[$key] = array_merge(LinkButton::getDefaultData(), $button); // get default data for each button and merge set newly button data to it
                }
            }
        }

        return [
            'button_group' => $this->buttonGroup,
            'class' => $this->class,
            // Other data for this component in the future, like style or something else
        ];
    }

    public function setEditableData($data) {
        if(isset($data['button_group']) && is_array($data['button_group']) && !empty($data['button_group'])) {
            foreach($data['button_group'] as $key => $button) {
                $data['button_group'][$key] = array_merge(LinkButton::getDefaultData(), $button); // get default data for each button and merge set newly button data to it
            }
        } else {
            $data['button_group'] = [
                LinkButton::getDefaultData() // Set button group to default to one button in array
            ];
        }

        $this->buttonGroup = $data['button_group'];
        $this->class = $data['class'];
        // Other data for this component in the future, like style or something else
    }

    public function renderFieldComponent($slot_name, $component_name) {
        return view('components.we-edit.field-components.link-button-group', [
            'slot_name' => $slot_name, 
            'component_name' => $component_name, 
            'component_data' => $this->getEditableData()
        ]);
    }
}
