<?php
namespace App\Listeners\Notifications;

use App\Models\Shop;
use Illuminate\Support\Facades\Log;
use App\Events\Eloquent\ItemsQueried;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Facades\CauserResolver;
use Illuminate\Notifications\Events\NotificationSent;

class ActivityLogNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * 
     * This listener should log the notifications being sent in activity log.
     * Default causer: Shop 1 (app)
     * Default subject: Notifiable
     *  
     * Description and custom_properties of Activity are taken from either toActivityLog (if defined) OR toDatabase
     * 
     * @param \Illuminate\Notifications\Events\NotificationSent $event
     * @return void
     */
    public function handle(NotificationSent $event)
    {
        // $event->channel
        // $event->notifiable
        // $event->notification
        // $event->response

        // TODO: This listener is run twice for some reason and produces duplicate activity logs....

        $notification = $event->notification;
        $notifiable = $event->notifiable;

        // Define who's the causer of the activity.
        if(!empty($notification->activity_log_causer ?? null) && $notification->activity_log_causer instanceof Model) {
            $causer = $notification->activity_log_causer;
        } else {
            $causer = Shop::find(1);
        }

        // Define who's the subject of activity.
        if(!empty($notification->activity_log_subject ?? null) && $notification->activity_log_subject instanceof Model) {
            $subject = $notification->activity_log_subject;
        } else {
            $subject = $notifiable;
        }

        // Get notification description
        if(method_exists($notification, 'toActivityLog')) {
            $notification_data = $notification->toActivityLog($notifiable);
        } else {
            $notification_data = $notification->toDatabase($notifiable);
        }

        // TODO: KEEP IN MIND THAT THIS EVENT HAPPENS FOR EACH CHANNEL (mail, database, slack, whatever...)! How to activity-log such cases?
        // For now it's logging 'notification_sent' activity only on mail sent!
        if($event->channel === 'mail') {
            activity()
                ->causedBy($causer)
                ->performedOn($subject)
                ->event('notification_sent') // goes to 'event' column
                ->withProperties($notification_data['data'] ?? [])
                ->log($notification_data['title'] ?? ''); // goes to 'description' column
        }
        
    }
}
