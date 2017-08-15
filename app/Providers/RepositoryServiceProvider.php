<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\VitalGym\Repositories\Contracts\UserRepository;
use App\VitalGym\Repositories\Contracts\TokenRepository;
use App\VitalGym\Repositories\Eloquent\EloquentUserRepository;
use App\VitalGym\Repositories\Eloquent\EloquentTokenRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(TokenRepository::class, EloquentTokenRepository::class);
    }
}
