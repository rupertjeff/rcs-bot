<?php

namespace Rcs\Bot\Console\Commands;

use Discord;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

/**
 * Class Server
 *
 * @package Rcs\Bot\Console\Commands
 */
class Server extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs the bot!';

    /**
     * @var array
     */
    protected $events = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($events = [])
    {
        parent::__construct();

        $this->addEvents($this->events);
        $this->addEvents($events);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Start Server');
        \Bot::setConsoleCommand($this);
        Discord::setCommand($this)->run();
    }

    /**
     * @param array $events
     */
    protected function addEvents(array $events = [])
    {
        foreach ($events as $event => $action) {
            $parsed = $this->parseEvent($action);
            Discord::on($event, $parsed);
        }
    }

    /**
     * @param string|callable $e
     *
     * @return \Closure
     */
    protected function parseEvent($e): \Closure
    {
        if (is_callable($e)) {
            return $e;
        }
        
        $class = $e;
        $method = 'handle';
        if (Str::contains($e, '@')) {
            list($class, $method) = explode('@', $e);
        }
        
        return function () use ($class, $method) {
            $parameters = func_get_args();
            $callable = [app($class), $method];
            
            return call_user_func_array($callable, $parameters);
        };
    }
}
