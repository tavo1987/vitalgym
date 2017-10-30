<?php

namespace  Tests;

use App\VitalGym\Entities\User;
use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * The base URL of the application.
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $this->baseUrl = $app->make('config')->get('app.url');

        return $app;
    }

    public function createNewUser( $attributes = [] )
    {
        $userData = [
            'email'      => 'tavo198718@gmail.com',
            'password'   => bcrypt('secret'),
            'active'     => true,
            'role'       => 'admin',
            'last_login' => '2017-08-20 13:15:00',
        ];

        if ($attributes) {
            return factory(User::class)->create($attributes);
        }

        return factory(User::class)->create($userData);

    }
}
