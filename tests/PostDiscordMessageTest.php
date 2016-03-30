<?php
/**
 * Name: PostDiscordMessageTest.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-03-28
 * Last Modified: 2016-03-28
 */
namespace Rcs\Bot\Tests;

use Discord\Cache\Cache;
use Discord\Cache\Drivers\ArrayCacheDriver;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithoutMiddleware;

/**
 * Class PostDiscordMessageTest
 *
 * @package Rcs\Bot\Tests
 */
class PostDiscordMessageTest extends TestCase
{
    use DatabaseMigrations, WithoutMiddleware;

    protected function setUp()
    {
        parent::setUp();

        /**
         * No need to use apc and create files from tests.
         *
         * TODO: Move this into a Facade
         */
        Cache::setCache(new ArrayCacheDriver());
    }

    /**
     * @test
     */
    public function it_sends_custom_messages()
    {
        $message = 'This is a custom message.';
        $this->visit('/')
            ->type($message, 'message')
            ->press('submit-custom-message')
            ->see('Message Posted!')
            ->seeInDatabase('messages', [
                'content' => $message,
            ]);
    }

    /**
     * @test
     */
    public function it_sends_custom_messages_at_user_defined_times()
    {
        $message = 'This is a delayed message.';
        $this->visit('/')
            ->type($message, 'delayed-message')
            ->select(60, 'delayed-delay')
            ->press('submit-delayed-message');

        $this->see('Message Posted!')
            ->seeInDatabase('messages', [
                'content' => $message,
            ]);
    }
}
