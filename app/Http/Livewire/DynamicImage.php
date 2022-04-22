<?php

namespace App\Http\Livewire;

use App\Models\Models\EVLabel;
use Livewire\Component;

class DynamicImage extends Component
{
    protected $rules = [
        'src.value' => 'required|string|min:6',
        'href.value' => 'string',
    ];

    public $label;

    public $src;

    public $href;

    public $show_input_field = false;

    public $info;

    public $type;

    public function mount($src, $href = '#', $type = 'text')
    {
        $this->src = $src;
        $this->href = $href;
    }

    /*  TODO: These could be moved to higher level component like Editable and extended  */
    public function editLabel()
    {
        $this->show_input_field = true;
    }

    public function closeEditing()
    {
        $this->show_input_field = false;
    }

    public function updateLabel()
    {
        $this->validate();

        /* Update Image Source */
        $editedLabel = EVLabel::where('key', $this->src->key)->first();
        $editedLabel->value = $this->src->value;
        $editedLabel->save();

        /* Update Image Link */
        $editedLabel = EVLabel::where('key', $this->href->key)->first();
        $editedLabel->value = $this->href->value;
        $editedLabel->save();

        $this->show_input_field = false;
    }

    public function render()
    {
        return view('livewire.dynamic-image');
    }
}
