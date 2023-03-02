<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Notifications\Messages\WeMailMessage;

class UserInviteNotification extends WeNotification
{
    use Queueable;

    public $invite;
    public $url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invite, $url)
    {
        $this->invite = $invite;
        $this->url = $url;
        $this->user = $invite->user;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toDatabase($notifiable) {
        return [
            'type' => translate('New user invited'),
            'data' => ['action' => 'new_user_invited', 'user_id' => $notifiable->id]
        ];
    }

    public function toMail($notifiable)
    {
        try {
            return (new WeMailMessage)
                        ->markdown('vendor.notifications.email')
                        ->subject(translate('You are invited to').' '.get_tenant_setting('site_name').' by '.($this->user->name.' '.$this->user->surname))
                        ->greeting(translate('You are invited to').' '.get_tenant_setting('site_name').' by '.($this->user->name.' '.$this->user->surname))
                        ->line('You have been invited to join '.get_tenant_setting('site_name').' by '.($this->user->name.' '.$this->user->surname))
                        ->line(translate('If you want to join, please click on the button below'))
                        ->action('Accept an invite', $this->url)
                        ->line('If you don\'t want to accept an invite, please discard this email.');
                        // ->mailersend();
        } catch(\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
