<?php

namespace App\VitalGym\Repositories;

use App\VitalGym\Entities\ActivationToken;

class ActivationTokenRepository extends BaseRepository
{
    /**
     * @return \App\VitalGym\Entities\ActivationToken;
     */
    public function getModel()
    {
        return new ActivationToken();
    }

    public function activateUserAccount($token)
    {
        $token = $this->tokenExists($token);
        $token->user()->update(['active' => true]);
        $token->delete();
        return $token->user;
    }

    public function tokenExists($token)
    {
        return $this->model->where('token', $token)->firstOrFail();
    }
}
