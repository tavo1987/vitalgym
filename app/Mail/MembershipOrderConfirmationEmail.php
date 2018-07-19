<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MembershipOrderConfirmationEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $membership;

    /**
     * MembershipOrderConfirmationEmail constructor.
     * @param $membership
     */
    public function __construct($membership)
    {
        $this->membership = $membership;
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
