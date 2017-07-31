<?php

use App\Mail\SendActivationToken;
use Illuminate\Support\Facades\Mail;
use App\Listeners\SendActivationEmail;
use App\VitalGym\Entities\ActivationToken;
use App\Events\UserRequestedActivationEmail;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActivationAccountTokenTest extends BrowserKitTestCase
{
    use DatabaseTransactions;

    public function test_user_can_resend_email_verification_with_token()
    {
        $this->expectsEvents(UserRequestedActivationEmail::class);

        $user = $this->createNewUser(['active' => false]);
        factory(ActivationToken::class, 1)->create([
            'user_id' => $user->id,
        ]);

        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('secret', 'password')
            ->press('Entrar')
            ->seePageIs('/login')
            ->dontSeeIsAuthenticated()
            ->seeText('Por favor verifica tu email para activar tu cuenta')
            ->click('Reenviar email de verificación');

        $this->seeText('Email de verificación enviado');
    }

    public function test_user_cannot_resend_email_verification_with_token()
    {
        $listener = Mockery::spy(SendActivationEmail::class);
        app()->instance(SendActivationEmail::class, $listener);

        $user = $this->createNewUser(['active' => false]);
        factory(ActivationToken::class)->create([
            'user_id' => $user->id,
        ]);

        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('secret', 'password')
            ->press('Entrar')
            ->seePageIs('/login')
            ->dontSeeIsAuthenticated()
            ->seeText('Por favor verifica tu email para activar tu cuenta')
            ->click('Reenviar email de verificación');

        $listener->shouldHaveReceived('handle')->with(Mockery::on(function ($event) use ($user) {
            return $event->user->id == $user->id;
        }))->once();

        $this->seeText('Email de verificación enviado');
    }

    public function test_user_can_receive_email_with_activation_token()
    {
        Mail::fake();
        $user = $this->createNewUser(['active' => false]);

        $token = factory(ActivationToken::class)->create([
            'user_id' => $user->id,
        ]);

        $this->get(route('auth.activate.resend', $user->email));

        Mail::assertSent(SendActivationToken::class, function ($mail) use ($token, $user) {
            return $mail->hasTo($user->email) && $mail->token->token === $token->token;
        });
    }

    public function test_user_dit_not_receive_activation_correct_token()
    {
        Mail::fake();
        $user = $this->createNewUser(['active' => false]);
        factory(ActivationToken::class)->create(['user_id' => $user->id]);
        $token_fake = factory(ActivationToken::class)->create();

        $this->get(route('auth.activate.resend', $user->email));

        Mail::assertNotSent(SendActivationToken::class, function ($mail) use ($token_fake) {
            return $mail->token->token === $token_fake->token;
        });
    }

    public function test_unregistered_user_cannot_get_email_with_activation_token()
    {
        $this->get(route('auth.activate.resend', 'fake@email.com'));

        $this->assertResponseStatus(404);
    }
}
