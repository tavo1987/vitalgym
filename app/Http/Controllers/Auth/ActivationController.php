<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Events\UserRequestedActivationEmail;
use App\VitalGym\Repositories\Contracts\UserRepository;
use App\VitalGym\Repositories\Contracts\TokenRepository;

class ActivationController extends Controller
{
    /**
     * @var TokenRepository
     */
    protected $tokenRepository;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    public function __construct(TokenRepository $tokenRepository, UserRepository  $userRepository)
    {
        $this->tokenRepository = $tokenRepository;
        $this->userRepository = $userRepository;
    }

    public function activate($token)
    {
        $user = $this->tokenRepository->activateUserAccount($token);
        if ($user) {
            auth()->login($user);
        }

        return redirect('/')->with(['message' => 'Gracias por activar tu cuenta', 'alert-type' => 'success']);
    }

    public function resend($email)
    {
        $user = $this->userRepository->findByEmail($email);

        if ($user->active) {
            return redirect('/');
        }

        event(new UserRequestedActivationEmail($user));

        return redirect('/login')->withInfo('Email de verificación enviado.');
    }
}
