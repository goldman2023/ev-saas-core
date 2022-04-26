<?php

namespace App\Events\Plans;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlanSubscriptionCancel
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $plan_subscription;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($plan_subscription)
    {
        $this->plan_subscription = $plan_subscription;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
