<?php

namespace Sitic\Auth\Listeners\UserPasswordReset;

use Sitic\Auth\Events\UserPasswordReset\UserPasswordResetUpdated;

class RunUserPasswordResetUpdatedListener
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
     * @param  UserPasswordResetUpdated  $event
     * @return void
     */
    public function handle(UserPasswordResetUpdated $event)
    {
        //
    }
}
