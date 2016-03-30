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
     * Discord constructor.
     *
     * @param string $email
     * @param string $password
     * @param string $token
     */
    public function __construct(string $email, string $password, string $token = null)
    {
        $this->instance = new \Discord\Discord($email, $password, $token);
    }

    /**
     * @return Collection
     */
    public function getChannels(): Collection
    {
        return $this->getGuild()->channels->where('type', 'text');
    }

    /**
     * @param string $channelName
     *
     * @return Channel
     */
    public function getChannel(string $channelName = ''): Channel
    {
        if ('' === $channelName) {
            return $this->getChannels()->first();
        }
        
        return $this->getChannels()->where('name', $channelName)->first();
    }

    /**
     * @return Collection
     */
    public function getGuilds(): Collection
    {
        return $this->instance->guilds;
    }

    /**
     * @param string $guildName
     *
     * @return Guild
     */
    public function getGuild(string $guildName = ''): Guild
    {
        if ('' === $guildName) {
            return $this->getGuilds()->first();
        }

        return $this->getGuilds()->where('name', $guildName)->first();
    }
}
