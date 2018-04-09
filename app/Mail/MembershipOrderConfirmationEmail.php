<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MembershipOrderConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * MembershipOrderConfirmationEmail constructor.
     * @param $order
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.membership-confirmation-email');
    }
}
