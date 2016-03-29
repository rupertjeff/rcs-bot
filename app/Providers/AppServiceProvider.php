<?php

namespace Rcs\Bot\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Rcs\Bot\Services\Discord;

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
        $this->app->singleton('discord', function (Application $app) {
            return new Discord(
                env('DISCORD_USER', null),
                env('DISCORD_PASSWORD', null)
            );
        });
    }
}
