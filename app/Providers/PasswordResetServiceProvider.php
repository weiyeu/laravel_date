<?php

namespace App\Providers;

use App\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Auth\Passwords\PasswordResetServiceProvider as IlluminatePasswordServiceProvider;

class PasswordResetServiceProvider extends IlluminatePasswordServiceProvider
{

    /**
     * Register the password broker instance.
     *
     * @return void
     * @override
     */
    protected function registerPasswordBroker()
    {
        $this->app->singleton('auth.password', function ($app) {
            return new PasswordBrokerManager($app);
        });

        $this->app->bind('auth.password.broker', function ($app) {
            return $app->make('auth.password')->broker();
        });
    }
}