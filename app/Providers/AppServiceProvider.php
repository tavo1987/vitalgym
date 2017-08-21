<?php

namespace App\Providers;

use App\VitalGym\Services\Auth\ActivationAccountService;
use App\VitalGym\Services\Contracts\ActivationAccountServiceContract;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(ActivationAccountServiceContract::class, ActivationAccountService::class);

        if ($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }
}
