<?php

use App\VitalGym\Entities\ActivationToken;
use App\VitalGym\Services\Auth\ActivationAccountService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ActivationAccountServiceTest extends TestCase
{
    use  DatabaseTransactions;

    public function makeService()
    {
        return app(ActivationAccountService::class);
    }


    public function test_it_active_user_account_if_token_exist()
    {
        $service =  $this->makeService();
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


    public function test_it_cannot_active_user_account_if_token_does_not_exist()
    {
        $service =  $this->makeService();
        $user = $this->createNewUser(['active' => false,]);
        $token = factory(ActivationToken::class, 1)->create(['user_id' => $user->id]);
        $fake_token = str_random(128);

        $service->activate($fake_token);

        $this->seeInDatabase('users', [
            'id' => $user->id,
            'active' => false,
        ]);
        $this->seeInDatabase('activation_tokens', ['id' => $token->id]);
        $this->dontSeeIsAuthenticated();
    }
}
