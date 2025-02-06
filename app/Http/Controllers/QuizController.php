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
        return Inertia::render('Quizzes', [
            'quizzes' => $quizzes,
        ]);
//        return view('quiz.index', compact('quizzes'));
    }

    public function create(Request $request): View
    {
        dd($request->all());
        $quiz = Quiz::firstOrCreate([
            'user_id' => Auth::id(),
            'title' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return view('quiz.custom.edit', compact('quiz'))->with('success', __('Quiz created!'));
    }

    public function show(Quiz $quiz): View
    {
        return view('quiz.custom.edit', compact('quiz'));
    }

    public function createRound(Quiz $quiz, Request $request): jsonResponse
    {
        $devSlug = strtolower(str_replace(' ', '_', $request->input('title')));

        Round::create(
            $request->only(['title', 'type']) + [
                'quiz_id' => $quiz->id,
                'dev_slug' => $devSlug,
            ]
        );

        $html = view('quiz.partials.tabs', compact('quiz'))->render();

        return response()->json(['html' => $html]);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $roundsData = $request->input('rounds', []);
            $uploadedFiles = $request->allFiles();

            foreach ($roundsData as $roundID => $roundContent) {
                $round = Round::find($roundID);
                if (!$round) {
                    continue;
                }

                switch($round->type) {
                    case '3-6-9':
                        $round->processThreeSixNine($roundContent);
                        break;
                    case 'collective-memory':

                        $questions = $roundContent['questions'] ?? [];
                        $answers = $roundContent['answers'] ?? [];
                        $images = $uploadedFiles['rounds'][$roundID]['questions'] ?? [];

                        foreach ($questions as $questionKey => $questionData) {
                            $round->processCollectiveMemory($round, $questionKey, $questionData, $images, $answers);
                        }
                        break;
                    default:
//                        $round->processDefaultRound($round, $questionKey, $questionData, $images, $answers);
                        break;
                }
            }

            session()->flash('success', __('Round data saved successfully!'));
            return back();
        } catch (\Exception $e) {
            Log::error('Failed to save round data: ' . $e->getMessage());
            session()->flash('error', __('Failed to save round data. Please try again.'));
            return back();
        }
    }

    public function delete(Quiz $quiz): JsonResponse
    {
        $quiz->delete();
        return response()->json([
            'message' => __('Quiz successfully deleted!'),
            'redirect' => route('quiz.index')
        ]);
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
