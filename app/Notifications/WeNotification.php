<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class WeNotification extends Notification
{
    public $throw_error = false;
    public $activity_log_causer = null;
    public $activity_log_subject = null;


    public function __construct($throw_error = false, $activity_log_causer = null, $activity_log_subject = null)
    {
        $this->throw_error = $throw_error;
        $this->activity_log_causer = $activity_log_causer;
        $this->activity_log_subject = $activity_log_subject;
    }

    public function toActivityLog($notifiable) {
        return $this->toDatabase($notifiable);
    }
}
