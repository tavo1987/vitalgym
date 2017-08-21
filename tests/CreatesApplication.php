<?php

namespace  Tests;

use Exception;
use App\Exceptions\Handler;
use App\VitalGym\Entities\User;
use App\VitalGym\Entities\Profile;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Debug\ExceptionHandler;

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

    public function createNewUser($data = [])
    {
        $userData = collect([
            'email'      => 'tavo198718@gmail.com',
            'password'   => bcrypt('secret'),
            'active'     => true,
            'role'       => 'admin',
            'last_login' => '2017-08-20 13:15:00',
        ]);

        if (! empty($data)) {
            foreach ($data as $key => $value) {
                $userData->put($key, $value);
            }
        }

        $user = factory(User::class)->create($userData->toArray());
        factory(Profile::class)->create([
            'name'      => 'Edwin',
            'last_name'  => 'Ramírez',
            'nick_name' => 'tavo',
            'avatar'    => 'https://s3-us-west-2.amazonaws.com/vitalgym/avatars/default-avatar.jpg',
            'address'   => 'My address',
            'user_id'   => $user->id,
        ]);

        return $user;
    }

    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct()
            {
            }

            public function report(Exception $e)
            {
                // no-op
            }

            public function render($request, Exception $e)
            {
                throw $e;
            }
        });
    }
}
