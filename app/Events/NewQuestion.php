<?php

namespace App\Events;

use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class NewQuestion implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public array $question;
    protected int $quizId;

    /**
     * Create a new event instance.
     */
    public function __construct(Question $question)
    {
        $this->question = (new QuestionResource($question))->resolve();
        $this->quizId = $question->round->quiz_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel('quiz.' . $this->quizId);
    }

    public function broadcastAs(): string
    {
        return 'NewQuestion';
    }
}
