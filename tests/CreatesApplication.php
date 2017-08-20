<?php

namespace  Tests;

use App\Exceptions\Handler;
use App\VitalGym\Entities\User;
use Exception;
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


    protected function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler {
            public function __construct() {}

            public function report(Exception $e)
            {
                // no-op
            }

            public function render($request, Exception $e) {
                throw $e;
            }
        });
    }
}
