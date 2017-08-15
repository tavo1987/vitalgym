<?php

namespace App\VitalGym\Repositories\Contracts;

interface TokenRepository
{
    public function activateUserAccount($token);

    public function tokenExists($token);
}
