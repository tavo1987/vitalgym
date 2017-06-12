<?php

use App\Listeners\SendActivationEmail;
use App\VitalGym\Entities\ActivationToken;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\VitalGym\Services\Auth\ActivationAccountService;

class ActivationAccountServiceTest extends TestCase
{
    use  DatabaseTransactions;

    public function makeService()
    {
        return app(ActivationAccountService::class);
    }

    public function test_it_active_user_account_if_token_exist()
    {
        $service = $this->makeService();
        $user = $this->createNewUser(['active' => false]);
        $token = factory(ActivationToken::class, 1)->create(['user_id' => $user->id]);

        $service->activate($token->token);

        $this->seeInDatabase('users', [
            'id' => $user->id,
            'active' => true,
        ]);
        $this->dontSeeInDatabase('activation_tokens', ['id' => $token->id]);
        $this->seeIsAuthenticated();
    }

    /**
     * @expectedException Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function test_it_cannot_active_user_account_if_token_does_not_exist()
    {
        $service = $this->makeService();
        $fake_token = str_random(128);

        $service->activate($fake_token);
    }

    public function test_it_can_resend_email_with_activation_token()
    {
        $listener = Mockery::spy(SendActivationEmail::class);
        app()->instance(SendActivationEmail::class, $listener);

        $service = $this->makeService();
        $user = $this->createNewUser(['email' => 'edwin@gmail.com', 'active' => false]);

        factory(ActivationToken::class, 1)->create(['user_id' => $user->id]);

        $service->resend('edwin@gmail.com');

        $listener->shouldHaveReceived('handle')->with(Mockery::on(function ($event) use ($user) {
            return $event->user->id == $user->id;
        }))->once();

    }
}
