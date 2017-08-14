<?php

namespace App\VitalGym\Repositories\Contracts;

Interface TokenRepository
{
    public function activateUserAccount($token);
    public function tokenExists($token);
}