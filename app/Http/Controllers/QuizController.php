<?php

namespace App\Http\Controllers;

use App\Events\QuizStarted;
use App\Models\Quiz;
use App\Models\Round;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class QuizController extends Controller
{
    public function index(): \Inertia\Response
    {
        $quizzes = Auth::user()->quizzes;
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

    public function openWaitingRoom(Quiz $quiz): JsonResponse|View
    {
        if (request()->ajax()) {
            // Return JSON response for player screen (popup)
            $html = view('quiz.hosted.waiting-room', compact('quiz'))->render();
            return response()->json(['html' => $html]);
        }

        // Return view for host screen
        return view('quiz.hosted.waiting-room', compact('quiz'));
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
