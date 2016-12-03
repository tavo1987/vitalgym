<?php

use App\VitalGym\Entities\ActivationToken;
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
            'active' => false,
        ]);

        $token = str_random(60);
        DB::table('password_resets')->insert(['email' => $user->email, 'token' => $token]);

        $this->visit('/password/reset/'.$token)
            ->type($user->email, 'email')
            ->type('laravel', 'password')
            ->type('laravel', 'password_confirmation')
            ->press('Restablecer la contraseña');

        $this->dontSeeIsAuthenticated()
            ->seePageIs('/login');
    }

    public function test_user_can_activate_account()
    {
        $user  = $this->createNewUser(['active' => false]);
        $token = factory(ActivationToken::class, 1)->create([
            'user_id' => $user->id,
        ]);

        $this->visitRoute('auth.activate.account', $token->token);

        $this->dontSeeInDatabase('activation_tokens', [
            'id'      => $token->id,
            'token'   => $token->token,
            'user_id' => $user->id,
        ]);

        $this->seeInDatabase('users', [
            'id'     => $user->id,
            'active' => true,
        ]);

        $this->seeIsAuthenticated();
        $this->seePageIs('/')
            ->seeText('Gracias por activar tu cuenta');
    }

    public function test_user_cannot_activate_account()
    {
        $user  = $this->createNewUser(['active' => false]);
        $token = str_random(128);

        $this->get(route('auth.activate.account', $token));

        $this->assertResponseStatus(404);

        $this->seeInDatabase('users', [
            'id'     => $user->id,
            'active' => false,
        ]);

        $this->dontSeeIsAuthenticated();
        $this->seeText('Página no encontrada');

    }
}
