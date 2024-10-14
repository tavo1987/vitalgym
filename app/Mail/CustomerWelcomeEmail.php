<?php

namespace App\Mail;

use App\VitalGym\Entities\Customer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerWelcomeEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    /**
     * @var Customer
     */
    public $customer;

    /**
     * Create a new message instance.
     *
     * @param  Customer  $customer
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Bienvenido a VitalGym')
                    ->view('emails.customer-welcome-email');
    }
}
