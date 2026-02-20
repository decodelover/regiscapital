<?php

namespace App\Mail;

use App\Models\Settings;
use App\Models\User;
use App\Models\User_plans;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LoanStatus extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $loan;
    public $status;
    public $subjectLine;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, User_plans $loan, string $status, ?string $subjectLine = null)
    {
        $this->user = $user;
        $this->loan = $loan;
        $this->status = $status;
        $this->subjectLine = $subjectLine ?? "Loan Status Update - {$status}";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $settings = Settings::find(1);

        return $this->markdown('emails.loan-status', [
            'settings' => $settings,
            'user' => $this->user,
            'loan' => $this->loan,
            'status' => $this->status,
        ])->subject($this->subjectLine);
    }
}

