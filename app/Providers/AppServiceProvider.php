<?php

namespace Rcs\Bot\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Bot as BotFacade;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Rcs\Bot\Console\Commands\Server;
use Rcs\Bot\Services\Bot;
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
        $this->app->singleton('rcs.discord', function (Application $app) {
            return new Discord(
                env('DISCORD_USER', null),
                env('DISCORD_PASSWORD', null)
            );
        });
        $this->app->singleton('rcs.bot', function (Application $app) {
            return new Bot(config('bot.commands'));
        });
        $this->app->bind(Server::class, function () {
            $events = [
                Event::MESSAGE_CREATE => function (Message $message, \Discord\Discord $discord) {
                    BotFacade::refreshCommands();
                    // Is this a valid command? If no, ignore.
                    if (starts_with($message->content, '!')) {
                        $pieces  = explode(' ', $message->content);
                        $command = array_shift($pieces);
                        BotFacade::executeCommand($command, $message);
                    }
                },
            ];

            return new Server($events);
        });
    }
}
