<?php

namespace Rcs\Bot\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
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
        if ( ! $this->app->environment('production')) {
            $this->app->register(IdeHelperServiceProvider::class);
        }
        $this->app->singleton('discord', function (Application $app) {
            return new Discord(
                env('DISCORD_USER', null),
                env('DISCORD_PASSWORD', null)
            );
        });
    }
}
