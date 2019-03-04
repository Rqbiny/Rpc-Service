<?php

namespace App\Providers;

use App\Tools\SendMessage\SendMessage;
use Illuminate\Support\ServiceProvider;

class LoginServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('login', function () {
            return app(SendMessage::class);
        });
    }
}
