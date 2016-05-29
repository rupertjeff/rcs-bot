<?php
/**
 * Name: Message.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-04-06
 * Last Modified: 2016-04-06
 */
namespace Rcs\Bot\Transformers;

use League\Fractal\TransformerAbstract;
use Rcs\Bot\Database\Models\Message as MessageModel;

/**
 * Class Message
 *
 * @package Rcs\Bot\Transformers
 */
class Message extends TransformerAbstract
{
    /**
     * @param MessageModel $message
     *
     * @return array
     */
    public function transform(MessageModel $message): array
    {
        $data = [
            'id'      => $message->getKey(),
            'content' => $message->getContent(),
        ];

        if (null !== $message->pivot) {
            $data['offset'] = (int)$message->pivot->offset;
        }

        return $data;
    }
}
