<?php

namespace App\VitalGym\Services\Auth;

use App\VitalGym\Repositories\ActivationTokenRepository;

class ActivationAccountService
{
    /**
     * @var ActivationTokenRepository
     */
    protected $tokenRepository;


    public function __construct(ActivationTokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function activate($token)
    {
        $user = $this->tokenRepository->activateUserAccount($token);

        if ( $user ) {
            auth()->login($user);
        }
    }

}