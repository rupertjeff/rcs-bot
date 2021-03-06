<?php

namespace Rcs\Bot\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Bot as BotFacade;
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Rcs\Bot\Console\Commands\Server;
use Rcs\Bot\Services\Bot as BotService;
use Rcs\Bot\Services\Discord as DiscordService;

/**
 * Class AppServiceProvider
 *
 * @package Rcs\Bot\Providers
 */
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
            return new DiscordService(
                env('DISCORD_TOKEN', '')
            );
        });
        $this->app->singleton('rcs.bot', function (Application $app) {
            return new BotService(config('bot.commands'));
        });
        $this->app->bind(Server::class, function () {
            $events = [
                Event::MESSAGE_CREATE => function (Message $message, Discord $discord) {
                    BotFacade::refreshCommands();
                    $guildsToFollow = config('bot.guilds');
                    // Is this a valid command? If no, ignore.
                    if (starts_with($message->content, '!') && in_array($message->fullChannel->guild->name, $guildsToFollow, true)) {
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
