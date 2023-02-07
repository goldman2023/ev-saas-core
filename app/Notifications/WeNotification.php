<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class WeNotification extends Notification
{
    public $throw_error = false;

    public function __construct($throw_error = false)
    {
        $this->throw_error = $throw_error;
    }
}
