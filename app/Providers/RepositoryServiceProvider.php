<?php

namespace App\Providers;

use App\VitalGym\Repositories\Contracts\{UserRepository, TokenRepository};
use App\VitalGym\Repositories\Eloquent\{EloquentUserRepository, EloquentTokenRepository};
use Illuminate\Support\ServiceProvider;

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
