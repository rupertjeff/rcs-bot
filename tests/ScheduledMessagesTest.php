<?php
/**
 * Name: ScheduledMessagesTest.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-04-06
 * Last Modified: 2016-04-06
 */
namespace Rcs\Bot\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response as Statuses;
use Rcs\Bot\Database\Models\Message;

/**
 * Class ScheduledMessagesTest
 *
 * @package Rcs\Bot\Tests
 */
class ScheduledMessagesTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function it_shows_scheduled_messages()
    {
        $this->visit(route('messages.index'))
            ->seeJson([]);

        factory(Message::class, 3)->create();
        $this->visit(route('messages.index'))
            ->seeJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'content',
                    ],
                ],
            ]);
    }

    /**
     * @test
     */
    public function it_creates_messages()
    {
        $this->post(route('messages.store'), [
            'content' => 'Message body',
        ])->seeJson([
            'data' => [
                'id'      => 1,
                'content' => 'Message body',
            ],
        ])->seeInDatabase('messages', [
            'content' => 'Message body',
        ])->assertResponseStatus(Statuses::HTTP_CREATED);
    }

    /**
     * @test
     */
    public function it_updates_messages()
    {
        $message = factory(Message::class)->create([
            'content' => 'Message body',
        ]);

        $this->put(route('messages.update', $message), [
            'content' => 'Message content',
        ])->seeJson([
            'data' => [
                'id'      => 1,
                'content' => 'Message content',
            ],
        ])->dontSeeJson([
            'content' => 'Message body',
        ])->seeInDatabase('messages', [
            'id'      => 1,
            'content' => 'Message content',
        ])->dontSeeInDatabase('messages', [
            'id'      => 1,
            'content' => 'Message body',
        ])->assertResponseOk();
    }

    /**
     * @test
     */
    public function it_deletes_messages()
    {
        $message = factory(Message::class)->create([
            'content' => 'Message body',
        ]);

        $this->delete(route('messages.destroy', $message))
            ->dontSeeInDatabase('messages', [
                'id'      => 1,
                'content' => 'Message body',
            ]);
    }
}
