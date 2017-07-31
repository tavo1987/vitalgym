<?php

namespace App\VitalGym\Contracts;

interface ActivationAccountServiceInterface
{
    public function activate($token);

    public function resend($token);
}
