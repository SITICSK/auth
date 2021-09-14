<?php

namespace Sitic\Auth\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;
use Sitic\Auth\Events\UserPasswordReset\UserPasswordResetCreated;
use Sitic\Auth\Events\UserPasswordReset\UserPasswordResetDeleted;
use Sitic\Auth\Events\UserPasswordReset\UserPasswordResetForceDeleted;
use Sitic\Auth\Events\UserPasswordReset\UserPasswordResetRestored;
use Sitic\Auth\Events\UserPasswordReset\UserPasswordResetUpdated;
use Sitic\Auth\Listeners\UserPasswordReset\RunUserPasswordResetCreatedListener;
use Sitic\Auth\Listeners\UserPasswordReset\RunUserPasswordResetDeletedListener;
use Sitic\Auth\Listeners\UserPasswordReset\RunUserPasswordResetForceDeletedListener;
use Sitic\Auth\Listeners\UserPasswordReset\RunUserPasswordResetRestoredListener;
use Sitic\Auth\Listeners\UserPasswordReset\RunUserPasswordResetUpdatedListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        /* User Password Reset */
        UserPasswordResetCreated::class => [RunUserPasswordResetCreatedListener::class],
        UserPasswordResetDeleted::class => [RunUserPasswordResetDeletedListener::class],
        UserPasswordResetForceDeleted::class => [RunUserPasswordResetForceDeletedListener::class],
        UserPasswordResetRestored::class => [RunUserPasswordResetRestoredListener::class],
        UserPasswordResetUpdated::class => [RunUserPasswordResetUpdatedListener::class],
    ];
}
