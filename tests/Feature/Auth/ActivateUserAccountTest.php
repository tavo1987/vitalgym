<?php

use App\VitalGym\Entities\ActivationToken;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActionAccountTest extends BrowserKitTestCase
{
    use  RefreshDatabase;

    /** @test */
    public function inactive_user_cannot_login()
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

    /** @test  */
    public function inactive_user_cannot_login_even_if_reset_his_password()
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

        $this->dontSeeIsAuthenticated();
    }

    /** @test */
    public function user_can_activate_account()
    {
        $user = $this->createNewUser(['active' => false]);

        $token = factory(ActivationToken::class)->create([
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

    /** @test  */
    public function user_cannot_activate_account()
    {
        $user = $this->createNewUser(['active' => false]);
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
