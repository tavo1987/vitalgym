<?php

namespace App\VitalGym\Repositories;

use App\VitalGym\Entities\User;

class UserRepository extends BaseRepository
{
    /**
     * @return mixed
     */
    public function getModel()
    {
        return new User();
    }

    public function findByEmail($email)
    {
        return  $this->model->where('email', $email)->firstOrFail();
    }
}
