<?php

namespace Sitic\Auth\Listeners\UserPasswordReset;

use Sitic\Auth\Events\UserPasswordReset\UserPasswordResetDeleted;

class RunUserPasswordResetDeletedListener
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
     * @param  UserPasswordResetDeleted  $event
     * @return void
     */
    public function handle(UserPasswordResetDeleted $event)
    {
        //
    }
}
