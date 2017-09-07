<?php

namespace App\VitalGym\Services\User;

use Carbon\Carbon;
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

    public function create($user)
    {
        $newUser = $this->userRepository->create([
            'email'      => $user->email,
            'password'   => $user->password,
            'role'       => $user->role,
            'active'     => $user->active,
            'last_login' => Carbon::now(),
        ]);

        $this->userRepository->createProfile($newUser->id, [
            'name'      => $user->name,
            'last_name' => $user->last_name,
            'nick_name' => $user->nick_name,
            'avatar'    => $user->avatar,
            'address'   => $user->address,
        ]);
    }
}
