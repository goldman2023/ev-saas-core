<?php

namespace App\Listeners\Eloquent;

use App\Events\Eloquent\ItemsQueried;

class CustomAttributesEagerLoad
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
     * @param  \App\Events\Eloquent\ItemsQueried  $event
     * @return void
     */
    public function handle(ItemsQueried $event)
    {
        dd($event->items->load(['custom_attributes' => function ($query) {
            dd($query);
        }]));
    }
}
