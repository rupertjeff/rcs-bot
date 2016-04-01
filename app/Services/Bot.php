<?php
/**
 * Name: Bot.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-03-30
 * Last Modified: 2016-03-30
 */
namespace Rcs\Bot\Services;

use Discord\Parts\Channel\Message;
use Illuminate\Support\Collection;
use Log;
use Rcs\Bot\Database\Models\Command;

/**
 * Class Bot
 *
 * @package Rcs\Bot\Services
 */
class Bot
{
    /**
     * @var string
     */
    protected $commandDelimiter;

    /**
     * @var string
     */
    protected $callableDelimiter;

    /**
     * @var Collection
     */
    protected $commands;

    /**
     * @var \Illuminate\Console\Command
     */
    protected $consoleCommand;

    /**
     * @var array
     */
    protected $defaultCommands;

    /**
     * Bot constructor.
     *
     * @param array $commands
     */
    public function __construct(array $commands = [])
    {
        $this->callableDelimiter = config('bot.delimiters.callable', '@');
        $this->commandDelimiter  = config('bot.delimiters.command', '!');
        $this->commands          = collect([]);
        $this->defaultCommands   = $commands;
        
        $this->initCommands($commands);
    }

    /**
     * @param array $commands
     */
    protected function initCommands(array $commands = [])
    {
        $this->initDatabaseCommands();
        foreach ($commands as $command => $action) {
            try {
                $this->defineCommand($command, $action);
            } catch (\InvalidArgumentException $e) {
                Log::error('Invalid command: [' . $command . '], [' . $action . ']');
            }
        }
    }

    /**
     *
     */
    protected function initDatabaseCommands()
    {
        $commands       = Command::all();
        $this->commands = $commands->keyBy('command');
    }

    /**
     * @param string $command
     * @param mixed  $action
     *
     * @return Command
     * @throws \InvalidArgumentException
     */
    public function defineCommand(string $command, $action): Command
    {
        if ( ! starts_with($command, $this->commandDelimiter)) {
            $command = $this->commandDelimiter . $command;
        }
        if ($this->commands->has($command)) {
            return $this->commands[$command];
        }
        if (0 < Command::where('command', $command)->count()) {
            return $this->commands[$command] = Command::where('command', $command)->first();
        }

        $action = $this->transformAction($action);

        return $this->commands[$command] = Command::create(compact('command', 'action'));
    }

    /**
     * @param mixed $action
     *
     * @return string
     * @throws \InvalidArgumentException
     */
    protected function transformAction($action): string
    {
        if (is_string($action)) {
            return $action;
        }

        // assume callable now...
        if (is_array($action)) {
            return implode($this->callableDelimiter, $action);
        }

        throw new \InvalidArgumentException('Invalid action sent to ' . __CLASS__ . '.');
    }

    /**
     * @param string  $command
     * @param Message $message
     *
     * @return bool
     */
    public function executeCommand(string $command, Message $message): bool
    {
        if ( ! $this->commands->has($command)) {
            return false;
        }

        /** @var Command $item */
        $item = $this->commands[$command];

        $response = $this->processAction($item, $message);
        if ($item->replyToUser()) {
            $message->reply($response);
        } else {
            $message->channel->sendMessage($response);
        }

        return true;
    }

    /**
     * @param Command $command
     * @param Message $message
     *
     * @return string
     */
    protected function processAction(Command $command, Message $message): string
    {
        $check = $command->action;
        if (str_contains($check, $this->callableDelimiter)) {
            list($check) = explode($this->callableDelimiter, $check);
        }
        if (class_exists($check)) {
            $class  = $command->action;
            $method = 'handle';
            if (str_contains($command->action, $this->callableDelimiter)) {
                list($class, $method) = explode($this->callableDelimiter, $command->action);
            }

            return call_user_func_array([app($class), $method], [$message]);
        }

        return $command->action;
    }

    /**
     * @return Collection
     */
    public function getCommands(): Collection
    {
        return $this->commands;
    }

    /**
     * @param \Illuminate\Console\Command $command
     *
     * @return $this
     */
    public function setConsoleCommand(\Illuminate\Console\Command $command)
    {
        $this->consoleCommand = $command;
        
        return $this;
    }

    /**
     * @return $this
     */
    public function refreshCommands()
    {
        $this->initCommands($this->defaultCommands);

        return $this;
    }
}
