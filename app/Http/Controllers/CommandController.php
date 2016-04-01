<?php
/**
 * Name: CommandController.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-03-30
 * Last Modified: 2016-03-30
 */
namespace Rcs\Bot\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Rcs\Bot\Database\Models\Command;
use Rcs\Bot\Http\Requests\Command\Create as CreateRequest;
use Rcs\Bot\Http\Requests\Command\Update as UpdateRequest;
use Rcs\Bot\Http\ResponderTrait;
use Rcs\Bot\Transformers\Command as CommandTransformer;

/**
 * Class CommandController
 *
 * @package Rcs\Bot\Http\Controllers
 */
class CommandController extends Controller
{
    use ResponderTrait;

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->respondOk(Command::all(), new CommandTransformer);
    }

    /**
     * @param CreateRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateRequest $request): JsonResponse
    {
        $attributes          = $request->only(['command', 'action']);
        $attributes['reply'] = (bool)$request->get('reply');
        $command             = Command::create($attributes);

        return $this->respondCreated($command, new CommandTransformer);
    }

    /**
     * @param UpdateRequest $request
     * @param Command       $command
     *
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Command $command): JsonResponse
    {
        $attributes = $request->only(['command', 'action', 'reply']);
        foreach ($attributes as $key => $value) {
            $command->$key = $value;
        }
        $command->save();

        return $this->respondOk($command, new CommandTransformer);
    }

    /**
     * @param Command $command
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(Command $command): JsonResponse
    {
        if ( ! $command->isDeletable()) {
            return $this->respondForbidden();
        }
        
        $command->delete();

        return $this->respondNoContent();
    }
}
