<?php
/**
 * Name: Schedule.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-04-07
 * Last Modified: 2016-04-07
 */
namespace Rcs\Bot\Transformers;

use League\Fractal\TransformerAbstract;
use Rcs\Bot\Database\Models\Schedule as ScheduleModel;

/**
 * Class Schedule
 *
 * @package Rcs\Bot\Transformers
 */
class Schedule extends TransformerAbstract
{
    /**
     * @param ScheduleModel $schedule
     *
     * @return array
     */
    public function transform(ScheduleModel $schedule): array
    {
        return [
            'id'           => $schedule->getKey(),
            'channel_id'   => $schedule->getChannelId(),
            'name'         => $schedule->getName(),
            'repeat'       => $schedule->getRepeat(),
            'start_at'     => $schedule->getStartAt(),
            'end_at'       => $schedule->getEndAt(),
            'repeat_count' => $schedule->getRepeatCount(),
        ];
    }
}
