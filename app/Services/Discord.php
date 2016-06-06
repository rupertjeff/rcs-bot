<?php
/**
 * Name: Discord.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-03-29
 * Last Modified: 2016-03-29
 */
namespace Rcs\Bot\Services;

use Carbon\Carbon;
use Discord\Discord as BaseDiscord;
use Discord\Helpers\Collection;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Guild\Guild;
use Discord\WebSockets\WebSocket;
use Illuminate\Console\Command;
use Rcs\Bot\Database\Models\Message;
use Rcs\Bot\Database\Models\Schedule;
use React\EventLoop\Factory;

/**
 * Class Discord
 *
 * @package Rcs\Bot\Services
 */
class Discord
{
    /**
     * @var BaseDiscord
     */
    protected $instance;

    /**
     * @var WebSocket
     */
    protected $socket;

    /**
     * @var array
     */
    protected $events = [];

    /**
     * @var Command
     */
    protected $command;

    /**
     * Discord constructor.
     *
     * @param string $token
     * @param array  $options
     */
    public function __construct(string $token = null, array $options = [])
    {
        $this->loop     = Factory::create();
        $this->instance = new BaseDiscord(array_merge($options, ['token' => $token]));
    }

    /**
     * @return \Discord\Helpers\Collection
     */
    public function getGuilds(): Collection
    {
        return $this->instance->guilds;
    }

    /**
     * @param string $guildName
     *
     * @return \Discord\Parts\Guild\Guild
     */
    public function getGuild(string $guildName = ''): Guild
    {
        if ('' === $guildName) {
            /** @var \Illuminate\Support\Collection $allowedGuilds */
            $allowedGuilds = collect(config('bot.guilds'));

            $guildName = $allowedGuilds->first();
        }

        return $this->getGuilds()->where('name', $guildName)->first();
    }

    /**
     * @param string $guildName
     *
     * @return Collection
     */
    public function getChannels(string $guildName = ''): Collection
    {
        return $this->getGuild($guildName)->channels->where('type', 'text');
    }

    /**
     * @param string $channelName
     * @param string $guildName
     *
     * @return Channel
     */
    public function getChannel(string $channelName = '', string $guildName = ''): Channel
    {
        if ('' === $channelName) {
            return $this->getChannels($guildName)->first();
        }

        return $this->getChannels($guildName)->where('name', $channelName)->first();
    }

    /**
     * @param string   $event
     * @param callable $action
     *
     * @return $this
     */
    public function on(string $event, callable $action)
    {
        $this->events[] = compact('event', 'action');

        return $this;
    }

    /**
     * @param Command $command
     *
     * @return $this
     */
    public function setCommand(Command $command)
    {
        $this->command = $command;

        return $this;
    }

    /**
     * @return WebSocket
     */
    public function run(): WebSocket
    {
        $this->output('Building Websocket...');
        $this->buildScheduler();
        $ws = new WebSocket($this->instance, $this->loop);

        $this->output('Attaching Events...');
        $ws->on('ready', function () use ($ws) {
            $this->output('Connected and Ready!');
            $this->output($this->getGuilds()->pluck('name'));
            $this->attachEvents($ws);
        });

        $this->output('Starting Server...');
        $ws->run();

        return $this->socket = $ws;
    }

    protected function buildScheduler()
    {
        $this->output('Adding Timer for Scheduled Messages...');
        $this->loop->addPeriodicTimer(1, function () {
            $generalChannel = $this->getChannel('general', 'Vex');
            /** @var \Illuminate\Database\Eloquent\Collection $messages */
            $messages = $this->getScheduledMessages();
            $messages->each(function (Message $message) use ($generalChannel) {
                $generalChannel->sendMessage($message->getContent());
            });
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getScheduledMessages()
    {
        return Schedule::getMessagesToSend(new Carbon);
    }

    /**
     * @param WebSocket $ws
     *
     * @return $this
     */
    protected function attachEvents(WebSocket $ws)
    {
        foreach ($this->events as $event) {
            $ws->on($event['event'], $event['action']);
        }

        return $this;
    }

    public function __call($method, $parameters)
    {
        if (method_exists($this->socket, $method)) {
            return call_user_func_array([$this->socket, $method], $parameters);
        }

        if (method_exists($this->instance, $method)) {
            return call_user_func_array([$this->instance, $method], $parameters);
        }

        throw new \BadMethodCallException(__CLASS__ . '::' . $method . '() does not exist.');
    }

    /**
     * @param string $text
     * @param string $type
     */
    protected function output(string $text, string $type = 'line')
    {
        if (null !== $this->command) {
            if ( ! method_exists($this->command, $type)) {
                $type = 'line';
            }
            $this->command->$type($text);
        }
    }
}
