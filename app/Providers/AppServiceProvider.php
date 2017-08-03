<?php

namespace App\Providers;

use App\VitalGym\Contracts\ActivationAccountServiceContract;
use App\VitalGym\Services\Auth\ActivationAccountService;
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
    }
}
