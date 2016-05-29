<?php
/**
 * Name: MessageController.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-04-06
 * Last Modified: 2016-04-06
 */
namespace Rcs\Bot\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Rcs\Bot\Database\Models\Message;
use Rcs\Bot\Http\Requests\Message\Create as CreateRequest;
use Rcs\Bot\Http\Requests\Message\Update as UpdateRequest;
use Rcs\Bot\Http\ResponderTrait;
use Rcs\Bot\Transformers\Message as MessageTransformer;

/**
 * Class MessageController
 *
 * @package Rcs\Bot\Http\Controllers
 */
class MessageController extends Controller
{
    use ResponderTrait;

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $messages = Message::all();

        return $this->respondOk($messages, new MessageTransformer);
    }

    /**
     * @param CreateRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateRequest $request): JsonResponse
    {
        $attributes = $request->only('content');
        $message = Message::create($attributes);

        return $this->respondCreated($message, new MessageTransformer);
    }

    /**
     * @param UpdateRequest $request
     * @param Message       $message
     *
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Message $message): JsonResponse
    {
        $attributes = $request->only('content');
        $message->content = $attributes['content'];
        $message->save();

        return $this->respondOk($message, new MessageTransformer);
    }

    /**
     * @param Message $message
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Message $message): JsonResponse
    {
        $message->delete();
        
        return $this->respondNoContent();
    }
}
