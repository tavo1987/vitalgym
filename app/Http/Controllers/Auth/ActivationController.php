<?php

namespace App\Http\Controllers\Auth;

use App\VitalGym\Entities\User;
use App\Http\Controllers\Controller;
use App\VitalGym\Services\Auth\ActivationAccountService;
use App\Events\UserRequestedActivationEmail;

class ActivationController extends Controller
{

    /**
     * @var ActivationAccountService
     */
    protected $service;

    public function __construct(ActivationAccountService $service)
    {
        $this->service = $service;
    }


    public function activate($token)
    {
        $this->service->activate($token);
        return redirect('/')->with(['message' => 'Gracias por activar tu cuenta', 'alert-type' => 'success']);
    }

    public function resend($email)
    {
        $user = User::where('email', $email)->firstOrFail();

        if ($user->active) {
            return redirect('/');
        }

        event(new UserRequestedActivationEmail($user));

        return redirect('/login')->withInfo('Email de verificación enviado.');
    }
}
