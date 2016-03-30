<?php

namespace Rcs\Bot\Jobs;

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
     * Create a new job instance.
     *
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $message = \Discord::getChannel('bot-testing')->sendMessage($this->message);
        Message::create([
            'content' => $message->content,
        ]);
    }
}
