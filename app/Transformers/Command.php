<?php
/**
 * Name: Command.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-03-30
 * Last Modified: 2016-03-30
 */
namespace Rcs\Bot\Transformers;

use League\Fractal\TransformerAbstract;
use Rcs\Bot\Database\Models\Command as CommandModel;

/**
 * Class Command
 *
 * @package Rcs\Bot\Transformers
 */
class Command extends TransformerAbstract
{
    /**
     * @param CommandModel $command
     *
     * @return array
     */
    public function transform(CommandModel $command): array
    {
        return [
            'id'      => (int)$command->getKey(),
            'command' => $command->getCommand(),
            'action'  => $command->getAction(),
            'reply'   => $command->replyToUser(),
        ];
    }
}
