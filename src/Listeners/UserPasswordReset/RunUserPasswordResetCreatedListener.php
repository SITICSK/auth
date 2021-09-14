<?php

namespace Sitic\Auth\Listeners\UserPasswordReset;

use Sitic\Auth\Events\UserPasswordReset\UserPasswordResetCreated;
use Sitic\Auth\Jobs\UsePasswordReset\SendResetCodeMailJob;

class RunUserPasswordResetCreatedListener
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
     * @param  UserPasswordResetCreated  $event
     * @return void
     */
    public function handle(UserPasswordResetCreated $event)
    {
        dispatch(new SendResetCodeMailJob($event->userPasswordReset))->onQueue('emails');
    }
}
