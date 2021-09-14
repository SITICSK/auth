<?php

namespace Sitic\Auth\Mail\UserPasswordReset;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Sitic\Auth\Http\Models\UserPasswordReset;

class ResetCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userResetPassword;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserPasswordReset $userPasswordReset)
    {
        $this->userResetPassword = $userPasswordReset;
    }

    /**
     * Build the message.
     *
     * @return ResetCodeMail|void
     */
    public function build()
    {
        if (!$this->userResetPassword->code) return;
        $splittedCode = [];
        foreach ($this->split_half(implode(' ', str_split($this->userResetPassword->code))) as $partCode) {
            $splittedCode[] = str_replace(' ', '', $partCode);
        }

        return $this->markdown('auth::reset.code')
            ->subject(__('Your password reset code'))
            ->with(['code' => $splittedCode]);
    }

    private function split_half($string, $center = 0.4) {
        $length2 = strlen($string) * $center;
        $tmp = explode(' ', $string);
        $index = 0;
        $result = Array('', '');
        foreach($tmp as $word) {
            if(!$index && strlen($result[0]) > $length2) $index++;
            $result[$index] .= $word.' ';
        }
        return $result;
    }

}
