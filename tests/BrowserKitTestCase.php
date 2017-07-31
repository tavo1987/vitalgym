<?php

use Tests\CreatesApplication;
use App\VitalGym\Entities\User;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class BrowserKitTestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createNewUser($data = []) : User
    {
        $userData = collect([
            'name'     => 'Edwin',
            'email'    => 'tavo198718@gmail.com',
            'password' => bcrypt('secret'),
            'active'   => true,
        ]);

        if (! empty($data)) {
            foreach ($data as $key => $value) {
                $userData->put($key, $value);
            }
        }

        return factory(User::class)->create($userData->toArray());
    }
}
