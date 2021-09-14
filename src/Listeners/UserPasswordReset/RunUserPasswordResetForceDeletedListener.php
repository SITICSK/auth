<?php

namespace Sitic\Auth\Listeners\UserPasswordReset;

use Sitic\Auth\Events\UserPasswordReset\UserPasswordResetForceDeleted;

class RunUserPasswordResetForceDeletedListener
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
     * @param  UserPasswordResetForceDeleted  $event
     * @return void
     */
    public function handle(UserPasswordResetForceDeleted $event)
    {
        //
    }
}
