<?php

namespace App\Mail;

use App\Models\Settings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class P2pOrder extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $subject;
    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $subject, $message)
    {
        $this->name = $name;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $settings = Settings::find(1);
        return $this->markdown('emails.orders.p2porder', ['settings' => $settings, 'name' => $this->name, 'message' => $this->message])
                    ->subject($this->subject);
    }
}
