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

    public function activateUser($token)
    {
        $token = $this->model->firstOrFail($token);

        $token->user()->update(['active' => true]);

        $token->delete();

        return $token->user;
    }

}