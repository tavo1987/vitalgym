<?php

namespace App\Providers;

use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\ServiceProvider;
use App\VitalGym\Services\User\UserService;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use App\VitalGym\Services\Auth\ActivationAccountService;
use App\VitalGym\Services\Contracts\UserServiceContract;
use App\VitalGym\Services\Contracts\ActivationAccountServiceContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }
}
