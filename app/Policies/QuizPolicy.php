<?php

namespace App\Policies;

use App\Models\Quiz;
use App\Models\User;

class QuizPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    // app/Policies/QuizPolicy.php

    public function start(User $user, Quiz $quiz)
    {
        return $user->id === $quiz->host_id;
    }

}
