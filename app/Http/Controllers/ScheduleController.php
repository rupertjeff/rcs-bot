<?php
/**
 * Name: ScheduleController.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-04-07
 * Last Modified: 2016-04-07
 */
namespace Rcs\Bot\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Rcs\Bot\Database\Models\Schedule;
use Rcs\Bot\Http\Requests\Schedule\Create as CreateRequest;
use Rcs\Bot\Http\Requests\Schedule\Update as UpdateRequest;
use Rcs\Bot\Http\ResponderTrait;
use Rcs\Bot\Transformers\Schedule as ScheduleTransformer;

/**
 * Class ScheduleController
 *
 * @package Rcs\Bot\Http\Controllers
 */
class ScheduleController extends Controller
{
    use ResponderTrait;

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $schedules = Schedule::all();

        return $this->respondOk($schedules, new ScheduleTransformer);
    }

    /**
     * @param CreateRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateRequest $request): JsonResponse
    {
        $schedule = Schedule::create($request->only('name', 'repeat', 'start_at', 'end_at'));
        foreach ($request->get('messages') as $messageObj) {
            $schedule->messages()->create([
                'content' => $messageObj['content'],
            ], [
                'offset' => (int)$messageObj['offset'],
            ]);
        }

        return $this->respondCreated($schedule, new ScheduleTransformer);
    }

    /**
     * @param Schedule $schedule
     *
     * @return JsonResponse
     */
    public function show(Schedule $schedule): JsonResponse
    {
        return $this->respondOk($schedule, new ScheduleTransformer);
    }

    /**
     * @param UpdateRequest $request
     * @param Schedule      $schedule
     *
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Schedule $schedule): JsonResponse
    {
        foreach ($request->only(['name', 'repeat', 'start_at', 'end_at']) as $key => $value) {
            $schedule->$key = $value;
        }
        $schedule->save();
        foreach ($request->get('messages') as $messageObj) {
            $schedule->messages()->updateOrCreate([
                'id' => $messageObj['id'],
            ], [
                'content' => $messageObj['content'],
            ], [
                'offset' => (int)$messageObj['offset'],
            ]);
        }

        return $this->respondOk($schedule, new ScheduleTransformer);
    }

    /**
     * @param Schedule $schedule
     *
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Schedule $schedule): JsonResponse
    {
        $schedule->delete();

        return $this->respondNoContent();
    }
}
