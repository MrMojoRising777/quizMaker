<?php

namespace App\Http\Controllers;

use App\Events\AnswerRevealed;
use App\Events\QuizStarted;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class QuizController extends Controller
{
    public function index(): \Inertia\Response
    {
        $quizzes = Auth::user()->quizzes()->with('rounds')->get();
        return Inertia::render('Quizzes/Index', [
            'quizzes' => $quizzes,
        ]);
    }

    public function create(Request $request): RedirectResponse
    {
        $quiz = Quiz::firstOrCreate([
            'user_id' => Auth::id(),
            'title' => $request->input('name'),
            'type' => $request->input('type'),
            'description' => $request->input('description'),
        ]);

        if($request->input('type') === 'custom') {
//            return Inertia::render('Quizzes/CustomQuiz', [
//                'quiz' => $quiz,
//            ]);
        }

        $quiz->prepareRounds();

        return redirect()->route('quizzes.show', ['quiz' => $quiz->id]);
    }

    public function show(Quiz $quiz): \Inertia\Response
    {
        return Inertia::render('Quizzes/Show', [
            'quiz' => $quiz->load('rounds.questions.answers'),
        ]);
    }

    public function delete(Quiz $quiz): RedirectResponse
    {
        $quiz->delete();
        return redirect()->route('quizzes.index')->with('message', __('Quiz successfully deleted!'));
    }

    public function previewHost(Quiz $quiz): \Inertia\Response
    {
        return Inertia::render('Quizzes/Previews/Host', [
            'quiz' => $quiz->load('rounds.questions.answers', 'rounds.rules'),
        ]);
    }

    public function previewPlayer(Quiz $quiz): \Inertia\Response
    {
        return Inertia::render('Quizzes/Previews/Player', [
            'quiz' => $quiz->load('rounds.questions.answers'),
            'questionId' => $quiz->rounds[0]->questions[0]->id,
        ]);
    }

    public function revealAnswer(Question $question)
    {
        broadcast(new AnswerRevealed($question->id));
        return response()->json(['status' => 'success']);
    }

    public function startQuiz(Quiz $quiz)
    {
        if (auth()->user()->hasRole(['Quizmaster', 'Super Admin'])) {
            if ($quiz->is_started) {
                return response()->json(['status' => 'Quiz already started'], 400);
            }

            $quiz->update(['is_started' => true, 'started_at' => now()]);
            $round = $quiz->rounds()->first();

            broadcast(new QuizStarted($quiz->id, $round))->toOthers();

            return response()->json(['status' => 'Quiz started']);
        }

        return response()->json(['status' => 'Not allowed!'], 403);
    }
}
