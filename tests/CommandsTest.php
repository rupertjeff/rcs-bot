<?php
/**
 * Name: CommandsTest.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-03-30
 * Last Modified: 2016-03-30
 */
namespace Rcs\Bot\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response as Statuses;
use Rcs\Bot\Database\Models\Command;

/**
 * Class CommandsTest
 *
 * @package Rcs\Bot\Tests
 */
class CommandsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function it_shows_the_current_commands()
    {
        $this->get(route('commands.index'))
            ->seeJson([]);

        factory(Command::class, 3)->create();
        $this->get(route('commands.index'))
            ->seeJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'command',
                        'action',
                        'reply',
                    ],
                ],
            ]);
    }

    /**
     * @test
     */
    public function it_creates_new_bot_commands()
    {
        $this->post(route('commands.store'), [
            'command' => '!test',
            'action'  => 'Show this test text.',
        ])->seeJson([
            'command' => '!test',
            'action'  => 'Show this test text.',
            'reply'   => false,
        ])->seeInDatabase('commands', [
            'command' => '!test',
            'action'  => 'Show this test text.',
            'reply'   => false,
        ])->assertResponseStatus(Statuses::HTTP_CREATED);

        $this->post(route('commands.store'), [
            'command' => '!test2',
            'action'  => 'Show that test text.',
            'reply'   => true,
        ])->seeJson([
            'command' => '!test2',
            'action'  => 'Show that test text.',
            'reply'   => true,
        ])->seeInDatabase('commands', [
            'command' => '!test2',
            'action'  => 'Show that test text.',
            'reply'   => true,
        ])->assertResponseStatus(Statuses::HTTP_CREATED);
    }

    /**
     * @test
     */
    public function it_updates_bot_commands()
    {
        $this->post(route('commands.store'), [
            'command' => '!test',
            'action'  => 'Some action.',
        ]);
        $command = Command::all()->first();
        $this->put(route('commands.update', $command), [
            'command' => '!test2',
            'action'  => 'Some action.',
            'reply'   => true,
        ])->seeJson([
            'command' => '!test2',
            'action'  => 'Some action.',
            'reply'   => true,
        ])->seeInDatabase('commands', [
            'command' => '!test2',
            'action'  => 'Some action.',
            'reply'   => true,
        ])->dontSeeInDatabase('commands', [
            'command' => '!test',
            'action'  => 'Some action.',
            'reply'   => false,
        ])->assertResponseOk();
    }

    /**
     * @test
     */
    public function it_deletes_bot_commands()
    {
        $this->post(route('commands.store'), [
            'command' => '!test',
            'action' => 'Some action.',
        ]);
        $command = Command::first();
        $this->delete(route('commands.delete', $command))
            ->dontSeeInDatabase('commands', [
                'command' => '!test',
            ]);
    }
}
