<?php

namespace App\VitalGym\Services\Auth;

use App\Events\UserRequestedActivationEmail;
use App\VitalGym\Repositories\Contracts\UserRepository;
use App\VitalGym\Repositories\Contracts\TokenRepository;
use App\VitalGym\Services\Contracts\ActivationAccountServiceContract;

class ActivationAccountService implements ActivationAccountServiceContract
{
    /**
     * @var TokenRepository
     */
    protected $tokenRepository;
    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(TokenRepository $tokenRepository, UserRepository $userRepository)
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
     * @return bool|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function resend($email)
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user->active) {
            return redirect('/');
        }

        event(new UserRequestedActivationEmail($user));

        return true;
    }
}
