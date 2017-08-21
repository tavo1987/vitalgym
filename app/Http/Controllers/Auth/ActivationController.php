<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\VitalGym\Services\Auth\ActivationAccountService as ActivationAccountService;

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
        $this->service->resend($email);

        return redirect('/login')->withInfo('Email de verificación enviado.');
    }
}
