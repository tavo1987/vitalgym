<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\VitalGym\Services\Auth\ActivationAccountService;
use App\VitalGym\Contracts\ActivationAccountServiceContract;
use Laravel\Dusk\DuskServiceProvider;

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
        }
    }
}
