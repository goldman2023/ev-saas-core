<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NotificationModal extends Component
{

    public $subject;
    public $success;

    public function mount($subject = null) {
        $this->subject = $subject;
        $this->success = false;
    }


    public function send() {
        $this->success = true;
    }
    public function render()
    {
        return view('livewire.notification-modal');
    }
}
