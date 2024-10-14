<?php

namespace App\Events;

use App\VitalGym\Entities\User;
use Illuminate\Queue\SerializesModels;

class UserRequestedActivationEmail
{
    use SerializesModels;
    /**
     * @var User
     */
    public $user;

    /**
     * UserRequestedActivationEmail constructor.
     *
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
