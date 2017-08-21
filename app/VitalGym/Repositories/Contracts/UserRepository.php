<?php

namespace App\VitalGym\Repositories\Contracts;

interface UserRepository
{
    public function findByEmail($email);

    public function paginateUsersWithProfile($perPage);
}
