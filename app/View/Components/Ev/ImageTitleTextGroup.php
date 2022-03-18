<?php

namespace App\View\Components\Ev;

use App\Models\Models\EVLabel;
use Illuminate\View\Component;

// class ImageTitleTextGroup extends WeEditableComponent
class ImageTitleTextGroup extends Component
{
    public $ittGroup;
    public $per_row;
    public $class;
    public $per_row_default = [
        'mobile' => 1,
        'tablet' => 2,
        'laptop' => 3,
        'desktop' => 4
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($ittGroup = [], $per_row = [], $class= '')
    {
        $this->ittGroup = $ittGroup;
        $this->per_row = $per_row;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.ev.image-title-text-group');
    }

    // WeEdit Builder
    public function getEditableData() {
        // ITT Group
        if(is_array($this->ittGroup)) {
            if(empty($this->ittGroup)) {
                $this->ittGroup = [
                    ImageTitleText::getDefaultData() // Set itt group to default to one itt in array
                ];
            } else {
                foreach($this->ittGroup as $key => $itt) {
                    $this->ittGroup[$key] = array_merge(ImageTitleText::getDefaultData(), $itt); // get default data for each itt and merge set newly itt data to it
                }
            }
        }

        
        //  Per Row
        if(is_array($this->per_row)) {
            if(empty($this->ittGroup)) {
                $this->per_row = $this->per_row_default;
            } else {
                $this->per_row = array_merge($this->per_row_default, $this->per_row);
            }
            
        }

        return [
            'itt_group' => $this->ittGroup,
            'per_row' => $this->per_row,
            'class' => $this->class,
            // Other data for this component in the future, like style or something else
        ];
    }

    public function setEditableData($data) {
        // ITT Group
        if(isset($data['itt_group']) && is_array($data['itt_group']) && !empty($data['itt_group'])) {
            foreach($data['itt_group'] as $key => $button) {
                $data['itt_group'][$key] = array_merge(ImageTitleText::getDefaultData(), $button); // get default data for each button and merge set newly button data to it
            }
        } else {
            $data['itt_group'] = [
                ImageTitleText::getDefaultData() // Set button group to default to one button in array
            ];
        }

        //  Per row
        if(isset($data['per_row']) && is_array($data['per_row']) && !empty($data['per_row'])) {
            $data['per_row'] = array_merge($this->per_row_default, $data['per_row']);
        } else {
            $data['per_row'] = $this->per_row_default;
        }

        $this->ittGroup = $data['itt_group'];
        $this->per_row = $data['per_row'];
        $this->class = $data['class'];
        // Other data for this component in the future, like style or something else
    }

    public function renderFieldComponent($slot_name, $component_name) {
        return view('components.we-edit.field-components.image-title-text-group', [
            'slot_name' => $slot_name, 
            'component_name' => $component_name, 
            'component_data' => $this->getEditableData()
        ]);
    }
}
