<?php

namespace App\Listeners;

use App\Events\UserRequestedActivationEmail;
use App\Mail\ActivationToken;
use App\Mail\SendActivationToken;
use Illuminate\Support\Facades\Mail;

class SendActivationEmail
{

    /**
     * Handle the event.
     *
     * @param  UserRequestedActivationEmail  $event
     * @return void
     */
    public function handle(UserRequestedActivationEmail $event)
    {
        Mail::to($event->user)->send(New SendActivationToken($event->user->token));
    }
}
