<?php

namespace App\VitalGym\Services\Contracts;

interface ActivationAccountServiceContract
{
    public function activate($token);

    public function resend($token);
}
