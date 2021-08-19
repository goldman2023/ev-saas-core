<?php

namespace App\Http\Livewire\Tenant;

use Livewire\Component;

class RatingInput extends Component
{
    public $rating = 0;

    public function render()
    {
        return view('livewire.tenant.rating-input');
    }

    public function setRating($val)
    {
        if ($this->rating == $val) {    // user can click on the same rating to reset the value
            $this->rating = 0;
        } else {
            $this->rating = $val;
        }
    }
    public function btnEvent(){
        $this->rating =5;
    }
}
