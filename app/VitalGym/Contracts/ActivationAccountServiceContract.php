<?php

namespace App\VitalGym\Contracts;

interface ActivationAccountServiceContract
{
    public function activate($token);

    public function resend($token);
}
