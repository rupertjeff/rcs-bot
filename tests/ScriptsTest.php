<?php
/**
 * Name: ScriptsTest.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-04-14
 * Last Modified: 2016-04-14
 */
namespace Rcs\Bot\Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Rcs\Bot\Database\Models\Message;
use Rcs\Bot\Database\Models\Script;

/**
 * Class ScriptsTest
 *
 * @package Rcs\Bot\Tests
 */
class ScriptsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function it_sends_scripts()
    {
        $this->get(route('scripts.index'))
            ->seeJson([]);

        factory(Script::class, 4)->create()->each(function (Script $script) {
            /** @var \Illuminate\Support\Collection $ids */
            $ids = factory(Message::class, random_int(3, 5))->create()->pluck('id', 'id')->map(function ($id) {
                return [
                    'offset' => random_int(0, 300),
                ];
            });

            $script->messages()->attach($ids->toArray());
        });
        $this->get(route('scripts.index'))
            ->seeJsonStructure([
                'data' => [
                    '*' => [
                        'name',
                        'messages' => [
                            'data' => [
                                '*' => [
                                    'content',
                                    'offset',
                                ],
                            ],
                        ],
                    ],
                ],
            ]);
    }

    /**
     * @test
     */
    public function it_adds_scripts()
    {
        $this->post(route('scripts.store'), [
            'name' => 'Script',
        ])->seeJson([
            'id'   => 1,
            'name' => 'Script',
        ]);
    }
    
    /**
     * @test
     */
    public function it_deletes_scripts()
    {
        $script = factory(Script::class)->create([
            'name' => 'Script',
        ]);
        $this->delete(route('scripts.destroy', $script))
            ->dontSeeInDatabase('scripts', [
                'name' => 'Script',
            ]);
    }
}
