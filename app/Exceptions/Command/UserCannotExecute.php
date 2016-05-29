<?php
/**
 * Name: UserCannotExecute.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-04-01
 * Last Modified: 2016-04-01
 */
namespace Rcs\Bot\Exceptions\Command;

use Discord\Parts\Channel\Message;
use RuntimeException;

/**
 * Class UserCannotExecute
 *
 * @package Rcs\Bot\Exceptions\Command
 */
class UserCannotExecute extends RuntimeException
{
    /**
     * @var Message
     */
    protected $discordMessage;

    /**
     * UserCannotExecute constructor.
     *
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->discordMessage = $message;
    }

    /**
     * @return Message
     */
    public function getDiscordMessage(): Message
    {
        return $this->message;
    }
}
