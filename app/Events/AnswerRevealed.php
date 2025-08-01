<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use App\Models\Question;

class AnswerRevealed implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public Question $question;
    public int $quizId;

    public function __construct(Question $question)
    {
        $this->question = $question;
        $this->quizId = $question->round->quiz_id;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('quiz.' . $this->quizId);
    }

    public function broadcastAs(): string
    {
        return 'AnswerRevealed';
    }
}
