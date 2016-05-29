<?php
/**
 * Name: ScheduleTest.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-04-07
 * Last Modified: 2016-04-07
 */
namespace Rcs\Bot\Tests;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response as Statuses;
use Rcs\Bot\Database\Models\Schedule;

/**
 * Class ScheduleTest
 *
 * @package Rcs\Bot\Tests
 */
class ScheduleTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function it_shows_schedules()
    {
        $this->visit(route('schedules.index'))
            ->seeJson([]);

        factory(Schedule::class, 3)->create();
        $this->visit(route('schedules.index'))
            ->seeJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'repeat',
                        'channel_id',
                        'start_at',
                        'end_at',
                    ],
                ],
            ])->assertResponseOk();
    }

    /**
     * @test
     */
    public function it_creates_a_schedule()
    {
        $this->post(route('schedules.store'), [
            'name'     => 'New Schedule',
            'repeat'   => 'weekly',
            'start_at' => Carbon::now()->format('U'),
            'end_at'   => Carbon::now()->addWeeks(2)->format('U'),
        ])->seeJson([
            'id'           => 1,
            'name'         => 'New Schedule',
            'repeat'       => 'weekly',
            'repeat_count' => 2,
            'start_at'     => (int)Carbon::now()->format('U'),
            'end_at'       => (int)Carbon::now()->addWeeks(2)->format('U'),
        ])->seeInDatabase('schedules', [
            'name'   => 'New Schedule',
            'repeat' => 'weekly',
        ])->assertResponseStatus(Statuses::HTTP_CREATED);
    }

    /**
     * @test
     */
    public function it_updates_a_schedule()
    {
        $timestamp = Carbon::now();
        /** @var Schedule $schedule */
        $schedule = factory(Schedule::class)->create([
            'name'     => 'New Schedule',
            'repeat'   => 'weekly',
            'start_at' => $timestamp->format('U'),
            'end_at'   => $timestamp->addWeeks(2)->format('U'),
        ]);

        $this->put(route('schedules.update', $schedule), [
            'name'     => 'Old Schedule',
            'repeat'   => 'weekly',
            'start_at' => '' . $schedule->getStartAt(),
            'end_at'   => '' . $schedule->getEndAt(),
        ])->seeJson([
            'id'           => $schedule->getKey(),
            'name'         => 'Old Schedule',
            'repeat'       => 'weekly',
            'repeat_count' => 2,
            'start_at'     => $schedule->getStartAt(),
            'end_at'       => $schedule->getEndAt(),
        ])->seeInDatabase('schedules', [
            'name' => 'Old Schedule',
        ])->dontSeeInDatabase('schedules', [
            'name' => 'New Schedule',
        ])->assertResponseOk();
    }

    /**
     * @test
     */
    public function it_deletes_schedules()
    {
        /** @var Schedule $schedule */
        $schedule = factory(Schedule::class)->create();

        $this->delete(route('schedules.destroy', $schedule))
            ->dontSeeInDatabase('schedules', [
                'name' => $schedule->getName(),
            ]);
    }
}
