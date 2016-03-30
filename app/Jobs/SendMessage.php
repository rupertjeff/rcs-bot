<?php

namespace Rcs\Bot\Jobs;

use Discord;
use Rcs\Bot\Database\Models\Message;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class SendMessage
 *
 * @package Rcs\Bot\Jobs
 */
class SendMessage extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $channel;

    /**
     * Create a new job instance.
     *
     * @param string $message
     * @param string $channel
     */
    public function __construct(string $message, string $channel = '')
    {
        $this->message = $message;
        $this->channel = $channel ?? env('DISCORD_CHANNEL');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = Discord::getChannel($this->channel)->sendMessage($this->message);
        Message::create([
            'content' => $message->content,
            'channel' => $this->channel,
        ]);
    }
}
