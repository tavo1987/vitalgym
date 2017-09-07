<?php

namespace App\VitalGym\Repositories\Eloquent;

use App\VitalGym\Entities\User;
use App\VitalGym\Repositories\BaseRepository;
use App\VitalGym\Repositories\Contracts\UserRepository;

class EloquentUserRepository extends BaseRepository implements UserRepository
{
    /**
     * @return string
     */
    public function entity()
    {
        return User::class;
    }

    public function findByEmail($email)
    {
        return $this->findWhereFirst('email', $email);
    }

    public function paginateUsersWithProfile($perPage)
    {
        return $this->entity->with('profile')->paginate($perPage);
    }

    public function createProfile($user_id, $properties)
    {
        return $this->find($user_id)->profile()->create($properties);
    }
}
