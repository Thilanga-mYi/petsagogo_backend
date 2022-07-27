<?php

namespace App\Providers;

use App\Interfaces\API\AuthInterface;
use App\Repositories\AuthRepository;
use Illuminate\Support\ServiceProvider;

class APIAuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(AuthInterface::class, AuthRepository::class);
    }
}
