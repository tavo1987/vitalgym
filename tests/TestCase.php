<?php

use App\User;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function createNewUser($data = []) : User
    {
        $userData = collect([
            'name'     => 'Edwin',
            'email'    => 'tavo198718@gmail.com',
            'password' => bcrypt('secret'),
            'active'   => true,
        ]);

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $userData->put($key, $value);
            }
        }

        return factory(User::class)->create($userData->toArray());
    }
}
