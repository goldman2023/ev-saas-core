<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Notification extends Component
{

    public $notification_flag = false;
    public $text = null;

    protected $listeners = ['success-notification' => 'showSuccessNotification', 'remove-notification' => 'removeNotification'];

    public function render()
    {
        return view('livewire.notification');
    }

    public function showSuccessNotification($message) {
        $this->text = $message;
        $this->notification_flag = true;
    }

    public function removeNotification() {
        $this->notification_flag = false;
    }
}
