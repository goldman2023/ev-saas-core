<?php

namespace App\Http\Livewire;

use App\Models\Models\EVLabel;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class DynamicLabel extends Component
{
    public $label;

    public $show_input_field = false;

    public $info;

    /* Available types for now: text, textarea */
    public $type = 'text';

    protected $rules = [
        'label.value' => 'required|string|min:6',
    ];

    public function mount($label, $type = 'text')
    {
        $this->type = $type;
        $this->show_input_field = false;
        $this->label = $label;
        $this->info = 0;
    }

    public function editLabel()
    {
        $this->info++;

        $this->show_input_field = true;
    }

    public function close()
    {
        $this->show_input_field = false;
    }

    public function updateLabel()
    {
        $this->validate();

        $editedLabel = EVLabel::where('key', $this->label->key)->first();
        $editedLabel->value = $this->label->value;
        $editedLabel->save();
        $this->show_input_field = false;
    }

    public function render()
    {
        return view('livewire.dynamic-label', [
            'label' => $this->label,
        ]);
    }
}
