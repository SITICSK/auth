<?php

namespace Sitic\Auth\Listeners\UserPasswordReset;

use Sitic\Auth\Events\UserPasswordReset\UserPasswordResetRestored;

class RunUserPasswordResetRestoredListener
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
     * @param  UserPasswordResetRestored  $event
     * @return void
     */
    public function handle(UserPasswordResetRestored $event)
    {
        //
    }
}
