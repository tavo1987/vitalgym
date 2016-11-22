<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActionAccountTest extends TestCase
{
    use  DatabaseTransactions;

    public function test_inactive_user_cannot_login()
    {
        $user = $this->createNewUser([
            'active' => false,
        ]);

        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('secret', 'password')
            ->press('Entrar');

        $this->dontSeeIsAuthenticated()
            ->seePageIs('/login');
    }

    public function test_inactive_user_cannot_login_even_if_reset_his_password()
    {
        $user = $this->createNewUser([
            'active' => false
        ]);

        $token = str_random(60);
        DB::table('password_resets')->insert(['email' => $user->email, 'token' => $token]);

        $this->visit('/password/reset/' . $token)
            ->type($user->email, 'email')
            ->type('laravel', 'password')
            ->type('laravel', 'password_confirmation')
            ->press('Restablecer la contraseña');

        $this->dontSeeIsAuthenticated()
            ->seePageIs('/login');

    }

}