<?php

namespace Sitic\Auth\Events\UserPasswordReset;

use App\Events\Event;
use Sitic\Auth\Http\Models\UserPasswordReset;

class UserPasswordResetForceDeleted extends Event
{
    public $userPasswordReset;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(UserPasswordReset $userPasswordReset)
    {
        $this->userPasswordReset = $userPasswordReset;
    }
}
