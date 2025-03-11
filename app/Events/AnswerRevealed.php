<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class AnswerRevealed implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public int $questionId;

    public function __construct($questionId)
    {
        $this->questionId = $questionId;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('quiz.' . $this->questionId);
    }

    public function broadcastAs(): string
    {
        return 'AnswerRevealed';
    }
}
