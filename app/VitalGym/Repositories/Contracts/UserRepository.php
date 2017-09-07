<?php

namespace App\VitalGym\Repositories\Contracts;

interface UserRepository
{
    public function findByEmail($email);

    public function paginateUsersWithProfile($perPage);

    public function createProfile($user_id, $properties);
}
