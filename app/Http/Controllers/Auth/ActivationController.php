<?php

namespace App\Http\Controllers\Auth;

use App\VitalGym\Entities\ActivationToken;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ActivationController extends Controller
{
    public function activate(ActivationToken $token)
    {
        $token->user()->update(['active' => true]);

        $token->delete();

        Auth::login($token->user);

        return redirect('/')->with(['message'=> 'Gracias por activar tu cuenta', 'alert-type' => 'success']);

    }
}
