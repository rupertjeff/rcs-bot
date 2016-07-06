<?php

namespace Rcs\Bot\Database\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as SupportCollection;

/**
 * Class Schedule
 *
 * @package Rcs\Bot\Database\Models
 *
 * @property-read \Illuminate\Database\Eloquent\Collection $messages
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
     * @param Carbon $timestamp
     *
     * @return Collection
     */
    public static function getMessagesToSend($timestamp = null): Collection
    {
        if (null === $timestamp) {
            $timestamp = Carbon::now();
        }

        // get messages that should be posted
        // grab schedules where start/end between $timestamp
        // check to see if schedule is currently running
        // for running schedules, check if message needs to be posted
        // send back messages to be sent
        $runningSchedules = static::running($timestamp);

        return $runningSchedules
            ->map(function (Schedule $schedule) use ($timestamp) {
                $potentialTimes = static::getPotentialTimesFromSchedule($schedule);

                foreach ($schedule->messages as $message) {
                    $messageTimes = static::getPotentialTimesFromMessage($message, $potentialTimes)
                        ->map(function (Carbon $time) {
                            return $time->format('U');
                        })->all();

                    if (in_array($timestamp->format('U'), $messageTimes, true)) {
                        return $message;
                    }
                }

                return null;
            })->filter();
    }

    /**
     * @param null $timestamp
     *
     * @return Collection
     */
    public static function running($timestamp = null): Collection
    {
        if (null === $timestamp) {
            $timestamp = new Carbon;
        }

        return static::where('start_at', '<=', $timestamp)
            ->where('end_at', '>=', $timestamp)
            ->get();
    }

    /**
     * @param Schedule $schedule
     *
     * @return SupportCollection
     */
    protected static function getPotentialTimesFromSchedule(Schedule $schedule)
    {
        $times[] = Carbon::createFromTimestamp($schedule->getStartAt());

        for ($i = 1; $i < $schedule->getRepeatCount(); $i++) {
            $times[] = Carbon::createFromTimestamp(
                $times[$i - 1]->format('U') + $schedule->getRepeatTypeDiff()
            );
        }

        return new SupportCollection($times);
    }

    /**
     * @param Message           $message
     * @param SupportCollection $potentialTimes
     *
     * @return SupportCollection
     */
    protected static function getPotentialTimesFromMessage(Message $message, SupportCollection $potentialTimes)
    {
        /** @var Carbon $timestamp */
        return $potentialTimes->map(function ($timestamp) use ($message) {
            return Carbon::createFromTimestamp($timestamp->format('U') + $message->pivot->offset * 60);
        });
    }

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
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function messages()
    {
        return $this->belongsToMany(Message::class)->withTimestamps()->withPivot(['offset']);
    }

    /**
     * @return int
     */
    protected function getRepeatTypeDiff(): int
    {
        $diff = 60;
        switch ($this->getRepeat()) {
            case 'monthly':
                // assume 4 weeks in a month
                // fall through to week
                $diff *= 4;

            case 'weekly':
                // get 7 days
                $diff *= 7;

            case 'daily':
                // get 1 day
                $diff *= 24;

            case 'hourly':
                // get 1 hour
                $diff *= 60;
        }

        return $diff;
    }

}
