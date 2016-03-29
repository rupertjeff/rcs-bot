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

use Discord\Helpers\Collection;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Guild\Guild;
use Discord\WebSockets\WebSocket;

/**
 * Class Discord
 *
 * @package Rcs\Bot\Services
 */
class Discord
{
    /**
     * @var \Discord\Discord
     */
    protected $instance;

    /**
     * @var WebSocket
     */
    protected $socket;

    /**
     * Discord constructor.
     *
     * @param string $email
     * @param string $password
     * @param string $token
     */
    public function __construct(string $email, string $password, string $token = null)
    {
        $this->instance = new \Discord\Discord($email, $password, $token);
        $this->socket   = new WebSocket($this->instance);
    }

    /**
     * @param string $channelName
     *
     * @return Channel
     */
    public function getChannel(string $channelName): Channel
    {
        return $this->getGuild()->channels->where('name', $channelName)->first();
    }

    /**
     * @param string $guildName
     *
     * @return Guild
     */
    public function getGuild(string $guildName = ''): Guild
    {
        if ('' === $guildName) {
            return $this->instance->guilds->first();
        }

        return $this->instance->guilds->where('name', $guildName)->first();
    }

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->getGuild()->members;
    }
}
