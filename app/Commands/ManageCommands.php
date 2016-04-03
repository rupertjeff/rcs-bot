<?php
/**
 * Name: ManageCommands.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-04-01
 * Last Modified: 2016-04-01
 */
namespace Rcs\Bot\Commands;

use Bot;
use Discord\Parts\Channel\Message;
use Rcs\Bot\Exceptions\Command\UserCannotExecute as UserCannotExecuteCommandException;

/**
 * Class ManageCommands
 *
 * @package Rcs\Bot\Commands
 */
class ManageCommands
{
    /**
     * @param Message $message
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    public function add(Message $message): string
    {
        try {
            $this->confirmUserCanRunCommand($message);
        } catch (UserCannotExecuteCommandException $e) {
            //TODO: Log error.
            return '';
        }

        $pieces = explode(' ', $message->content);
        // Remove original command, because we already know what it is.
        array_shift($pieces);
        $command = array_shift($pieces);
        $action = implode(' ', $pieces);
        try {
            Bot::defineCommand($command, $action);
        } catch (\Throwable $e) {
            //TODO: Log error.
        }
        
        return '';
    }

    /**
     * @param Message $message
     *
     * @return string
     */
    public function remove(Message $message): string
    {
        try {
            $this->confirmUserCanRunCommand($message);
        } catch (UserCannotExecuteCommandException $e) {
            //TODO: Log error.
            return '';
        }

        list($remove, $command) = explode(' ', $message->content);
        try {
            Bot::removeCommand($command);
        } catch (\Throwable $e) {
            //TODO: Log error.
        }
        
        return '';
    }

    /**
     * @param Message $message
     *
     * @throws UserCannotExecuteCommandException
     */
    protected function confirmUserCanRunCommand(Message $message)
    {
        $adminRoles = config('bot.admin');
        $user = \Discord::getGuild(config('bot.guild'))->members->get('id', $message->author->id);
        /** @var \Discord\Helpers\Collection $same */
        $same = $user->roles->filter(function ($value) use ($adminRoles) {
            return in_array($value->name, $adminRoles, false);
        });
        if (0 >= $same->count()) {
            throw new UserCannotExecuteCommandException($message);
        }
    }
}
