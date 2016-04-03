<?php
/**
 * Name: ListAllCommand.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-03-30
 * Last Modified: 2016-03-30
 */
namespace Rcs\Bot\Commands;

use Discord\Parts\Channel\Message;
use Rcs\Bot\Database\Models\Command;

/**
 * Class ListAllCommand
 *
 * @package Rcs\Bot\Commands
 */
class ListAllCommand
{
    /**
     * @param Message $message
     */
    public function handle(Message $message)
    {
        /** @var \Illuminate\Support\Collection $commands */
        $commands = \Bot::getCommands();
        
        $commandList = $commands->map(function (Command $command) {
            return $command->command;
        })->implode(', ');
        
        $message->channel->sendMessage('Here are the available commands: ' . $commandList);
    }
}
