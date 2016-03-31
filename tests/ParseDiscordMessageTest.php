<?php
/**
 * Name: ParseDiscordMessageTest.php
 * Description:
 * Version: 0.0.1
 * Author: jeffr
 * Created: 2016-03-30
 * Last Modified: 2016-03-30
 */
namespace Rcs\Bot\Tests;

/**
 * Class ParseDiscordMessageTest
 *
 * @package Rcs\Bot\Tests
 */
class ParseDiscordMessageTest extends TestCase
{
//    protected function setUp()
//    {
//        parent::setUp();
//
//        $this->artisan('bot:run');
//    }
//
//    protected function tearDown()
//    {
//        parent::tearDown();
//
//        $this->artisan('bot:stop');
//    }
//
//    /**
//     * @test
//     */
//    public function it_parses_a_predefined_command()
//    {
//        $command = '!command';
//        $action = 'Display text';
//        \Bot::defineCommand($command, $action);
//        \Discord::getChannel('bot-testing')->sendMessage($command);
//    }
    /**
     * @test
     */
    public function it_succeeded()
    {
        $this->assertTrue(true);
    }
}
