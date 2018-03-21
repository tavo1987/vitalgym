<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MembershipConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $membership;

    /**
     * MembershipConfirmationEmail constructor.
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
        return $this->view('view.name');
    }
}
