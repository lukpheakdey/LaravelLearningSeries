<?php

namespace App\Listeners;

use App\Events\UserEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Notifications\UserNotification;

class UserEventListener implements ShouldQueue
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
     * @param  UserEvent  $event
     * @return void
     */
    public function handle(UserEvent $event)
    {
        $user = $event->user;

        $user->notify(new UserNotification([
            'message' => $user->name. ' your profile is created successfully.'
        ]));
    }
}
