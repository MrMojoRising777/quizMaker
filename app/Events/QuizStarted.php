<?php

namespace App\Events;

use App\Models\Round;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuizStarted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $quizId;
    public $round;

    /**
     * Create a new event instance.
     */
    public function __construct(int $quizId, Round $round)
    {
        $this->quizId = $quizId;
        $this->round = $round;
    }

    public function broadcastOn()
    {
        return new Channel('quiz.' . $this->quizId);
    }

    public function broadcastAs()
    {
        return 'QuizStarted';
    }

    public function broadcastWith()
    {
        return [
            'quiz_id' => $this->quizId,
            'round' => $this->round,
        ];
    }
}
