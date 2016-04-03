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
use Symfony\Component\Console\Output\OutputInterface;

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
     * @param string $command
     *
     * @return bool
     */
    public function removeCommand(string $command): bool
    {
        if ($this->commands->has($command)) {
            unset($this->commands[$command]);
        }
        Command::where('command', $command)->delete();

        return true;
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
            $this->displayMessage('Command [' . $command . '] does not exist.');

            return false;
        }

        /** @var Command $item */
        $item = $this->commands[$command];

        return $this->processAction($item, $message);
    }

    /**
     * @param Command $command
     * @param Message $message
     *
     * @return bool
     */
    protected function processAction(Command $command, Message $message): bool
    {
        if ($this->isMessageClass($command)) {
            return $this->runActionClass($command, $message);
        }

        return $this->sendMessage($command, $message);
    }

    /**
     * @return Collection
     */
    public function getCommands(): Collection
    {
        return $this->commands;
    }

    /**
     * @return $this
     */
    public function refreshCommands()
    {
        $this->initCommands($this->defaultCommands);

        return $this;
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
     * @param string $message
     * @param string $func
     */
    protected function displayMessage(string $message, string $func = 'info')
    {
        if (null !== $this->consoleCommand && method_exists($this->consoleCommand, $func)) {
            if ('line' === $func) {
                $this->consoleCommand->line($message, null, OutputInterface::VERBOSITY_VERBOSE);
            } else {
                $this->consoleCommand->$func($message, OutputInterface::VERBOSITY_VERBOSE);
            }
        }
    }

    /**
     * @param Command $command
     * @param Message $message
     *
     * @return bool
     */
    protected function sendMessage(Command $command, Message $message): bool
    {
        $this->displayMessage('Command [' . $command->command . '] simply replies with a message.');
        if ($command->replyToUser()) {
            $message->reply($command->action);
        } else {
            $message->channel->sendMessage($command->action);
        }

        return true;
    }

    /**
     * @param Command $command
     *
     * @return bool
     */
    protected function isMessageClass(Command $command): bool
    {
        $check = $command->action;
        if (str_contains($check, $this->callableDelimiter)) {
            list($check) = explode($this->callableDelimiter, $check);
        }

        return class_exists($check);
    }

    /**
     * @param Command $command
     * @param Message $message
     *
     * @return bool
     */
    protected function runActionClass(Command $command, Message $message): bool
    {
        list($class, $method) = $this->getActionClass($command);

        $this->displayMessage('Command [' . $command->command . '] running ' . $class . '@' . $method);
        try {
            app($class)->$method($message);
            $this->displayMessage('Command [' . $command->command . '] succeeded, no output.');

            return true;
        } catch (\Exception $e) {
            $this->displayMessage('Command [' . $command->command . '] failed.');
            
            return false;
        }
    }

    /**
     * @param Command $command
     *
     * @return array
     */
    protected function getActionClass(Command $command): array
    {
        $class  = $command->action;
        $method = 'handle';
        if (str_contains($command->action, $this->callableDelimiter)) {
            list($class, $method) = explode($this->callableDelimiter, $command->action);
        }

        return [$class, $method];
    }
}
