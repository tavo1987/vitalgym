<?php

use App\User;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use MailThief\Testing\InteractsWithMail;

class AuthenticationUserTest extends TestCase
{
    use DatabaseTransactions, InteractsWithMail;

    public function test_user_can_login()
    {
        $user = $this->createNewUser();

        $this->visit('/')
            ->seePageIs('/login')
            ->type('tavo198718@gmail.com', 'email')
            ->type('secret', 'password')
            ->press(trans('login.buttonsign'));

        $this->SeeIsAuthenticated()
            ->seeText('.user-panel', $user->name);
    }

    public function test_guest_user_cannot_login()
    {
        $this->visit('/')
            ->seePageIs('/login')
            ->press('Entrar');

        $this->seePageIs('/login')
            ->seeText('El campo correo electrónico es obligatorio')
            ->seeText('El campo contraseña es obligatorio')
            ->dontSeeIsAuthenticated();
    }

    public function test_user_can_logout()
    {
        $user = $this->createNewUser();

        $this->actingAs($user)
            ->visit('/')
            ->see('Bienvenido')
            ->seeText($user->name)
            ->post('/logout');

        $this->dontSeeIsAuthenticated()
            ->visit('/')
            ->seePageIs('login');
    }

}
