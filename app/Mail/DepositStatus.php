<?php

namespace App\Mail;

use App\Models\Deposit;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DepositStatus extends Mailable
{
    use Queueable, SerializesModels;
    public $deposit, $subject, $user;
    public $foramin;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Deposit $deposit, User $user, $subject, $foramin = false)
    {
        $this->deposit = $deposit;
        $this->user = $user;
        $this->foramin = $foramin;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $settings = Settings::find(1);
        return $this->markdown('emails.success-deposit', ['settings' => $settings, 'deposit' => $this->deposit, 'user' => $this->user, 'foramin' => $this->foramin])->subject($this->subject);
    }
}
