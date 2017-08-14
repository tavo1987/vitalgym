<?php

namespace App\VitalGym\Services\Auth;

use App\Events\UserRequestedActivationEmail;
use App\VitalGym\Repositories\UserRepository;
use App\VitalGym\Repositories\EloquentTokenRepository;
use App\VitalGym\Contracts\ActivationAccountServiceContract;

class ActivationAccountService implements ActivationAccountServiceContract
{
    /**
     * @var EloquentTokenRepository
     */
    protected $tokenRepository;
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(EloquentTokenRepository $tokenRepository, UserRepository $userRepository)
    {
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param $token
     */
    public function activate($token)
    {
        $user = $this->tokenRepository->activateUserAccount($token);

        if ($user) {
            auth()->login($user);
        }
    }

    /**
     * @param $email
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function resend($email)
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user->active) {
            return redirect('/');
        }
        event(new UserRequestedActivationEmail($user));
    }
}
