<?php

namespace App\VitalGym\Services\User;

use App\VitalGym\Repositories\Contracts\UserRepository;
use App\VitalGym\Services\Contracts\UserServiceContract;

class UserService implements UserServiceContract
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function paginateUsers($perPage = 10)
    {
        return $this->userRepository->paginateUsersWithProfile($perPage);
    }
}