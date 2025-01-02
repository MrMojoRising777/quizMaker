<?php

namespace App\Http\Controllers;

use App\Models\HostedQuiz;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HostedQuizController extends Controller
{
    public function showWaitingRoom($id): RedirectResponse|View
    {
        $hostedQuiz = HostedQuiz::with('players.user')->findOrFail($id);

        if ($hostedQuiz->status !== 'pending') {
            return redirect()->route('some-error-page')->with('error', 'Quiz has already started or completed.');
        }

        return view('waiting-room', ['hostedQuiz' => $hostedQuiz]);
    }
}
