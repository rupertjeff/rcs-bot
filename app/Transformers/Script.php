<?php
/**
 * Name: Script.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-04-14
 * Last Modified: 2016-04-14
 */
namespace Rcs\Bot\Transformers;

use League\Fractal\TransformerAbstract;
use Rcs\Bot\Database\Models\Script as ScriptModel;

/**
 * Class Script
 *
 * @package Rcs\Bot\Transformers
 */
class Script extends TransformerAbstract
{
    /**
     * @var array
     */
    public $defaultIncludes = ['messages'];

    /**
     * @param ScriptModel $script
     *
     * @return array
     */
    public function transform(ScriptModel $script): array
    {
        return [
            'id'   => $script->getKey(),
            'name' => $script->getName(),
        ];
    }

    /**
     * @param ScriptModel $script
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeMessages(ScriptModel $script)
    {
        return $this->collection($script->messages, new Message);
    }
}
