<?php
/**
 * Name: ScriptController.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-04-14
 * Last Modified: 2016-04-14
 */
namespace Rcs\Bot\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Rcs\Bot\Database\Models\Script;
use Rcs\Bot\Http\Requests\Script\Create as CreateRequest;
use Rcs\Bot\Http\ResponderTrait;
use Rcs\Bot\Transformers\Script as ScriptTransformer;

/**
 * Class ScriptController
 *
 * @package Rcs\Bot\Http\Controllers
 */
class ScriptController extends Controller
{
    use ResponderTrait;

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->respondOk(Script::all(), new ScriptTransformer);
    }

    /**
     * @param CreateRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateRequest $request): JsonResponse
    {
        $script = Script::create($request->only('name'));
        
        return $this->respondCreated($script, new ScriptTransformer);
    }

    /**
     * @param Script $script
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Script $script)
    {
        $script->delete();
        
        return $this->respondNoContent();
    }
}
