<?php

namespace Sitic\Auth\Jobs\UsePasswordReset;

use App\Jobs\Job;
use Illuminate\Support\Facades\Mail;
use Sitic\Auth\Http\Models\UserPasswordReset;
use Sitic\Auth\Mail\UserPasswordReset\ResetCodeMail;

class SendResetCodeMailJob extends Job
{
    protected $userPasswordReset;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(UserPasswordReset $userPasswordReset)
    {
        $this->userPasswordReset = $userPasswordReset;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->userPasswordReset->user)->send(new ResetCodeMail($this->userPasswordReset));
    }
}
