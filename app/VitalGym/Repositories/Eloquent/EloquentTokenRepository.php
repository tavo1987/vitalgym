<?php

namespace App\VitalGym\Repositories\Eloquent;

use App\VitalGym\Entities\ActivationToken;
use App\VitalGym\Repositories\BaseRepository;
use App\VitalGym\Repositories\Contracts\TokenRepository;

class EloquentTokenRepository extends BaseRepository implements TokenRepository
{
    /**
     * @return string
     */
    public function entity()
    {
        return ActivationToken::class;
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
        return $this->findWhereFirst('token', $token);
    }
}
