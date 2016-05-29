<?php

namespace Rcs\Bot\Database\Models;

use DateInterval;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Schedule
 *
 * @package Rcs\Bot\Database\Models
 */
class Schedule extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['channel_id', 'name', 'repeat', 'start_at', 'end_at'];

    /**
     * @var array
     */
    protected $dates = ['start_at', 'end_at'];

    /**
     * @return int
     */
    public function getChannelId(): int
    {
        return (int)$this->getAttribute('channel_id');
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->getAttribute('name');
    }

    /**
     * @return string
     */
    public function getRepeat(): string
    {
        return $this->getAttribute('repeat');
    }

    /**
     * @return int
     */
    public function getStartAt(): int
    {
        return (int)$this->getAttribute('start_at')->format('U');
    }

    /**
     * @return int
     */
    public function getEndAt(): int
    {
        return (int)$this->getAttribute('end_at')->format('U');
    }

    /**
     * @return int
     */
    public function getRepeatCount(): int
    {
        $typeDiff     = $this->getRepeatTypeDiff();
        $durationDiff = $this->getEndAt() - $this->getStartAt();

        return floor($durationDiff / $typeDiff);
    }

    /**
     * @return int
     */
    protected function getRepeatTypeDiff(): int
    {
        // 1 day
        $diff = 60 * 60 * 24;
        switch ($this->getRepeat()) {
            case 'monthly':
                // assume 4 weeks in a month
                // fall through to week
                $diff *= 4;

            case 'weekly':
                // get 7 days
                $diff *= 7;
        }

        return $diff;
    }

}
