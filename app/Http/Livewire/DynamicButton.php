<?php

namespace App\Http\Livewire;

use App\Models\Models\EVLabel;
use Livewire\Component;

class DynamicButton extends Component
{

    public $label;
    public $href;
    public $show_input_field = false;
    public $type;
    public $target;

    protected $rules = [
        'href.value' => 'string|required',
        'label.value' => 'string|required',
    ];

    public function mount($label, $href = '#',   $type = 'text' )
    {
        $this->href = $href;
        $this->label = $label;
    }


    public function editLabel()
    {
        $this->show_input_field = true;
    }

    public function close() {
        $this->show_input_field = false;
    }

    public function updateLabel()
    {
        $this->validate();

        /* Update Link Href */
        $editedLabel = EVLabel::where('key', $this->href->key)->first();
        $editedLabel->value = $this->href->value;
        $editedLabel->save();

        /* Update Image Link */
        $editedLabel = EVLabel::where('key', $this->label->key)->first();
        $editedLabel->value = $this->label->value;
        $editedLabel->save();


        $this->show_input_field = false;
    }

    public function render()
    {
        return view('livewire.dynamic-button');
    }
}
