<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Round;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class QuizController extends Controller
{
    public function index(): View
    {
        $quizzes = Auth::user()->quiz;
        return view('quiz.index', compact('quizzes'));
    }

    public function create(Request $request): View
    {
        $quiz = Quiz::firstOrCreate([
            'user_id' => Auth::id(),
            'title' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return view('quiz.custom.edit', compact('quiz'))->with('success', 'Quiz created');
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

                $roundType = $round->type;
                $questions = $roundContent['questions'] ?? [];
                $answers = $roundContent['answers'] ?? [];
                $images = $uploadedFiles['rounds'][$roundID]['questions'] ?? [];

                foreach ($questions as $questionKey => $questionData) {
                    if ($roundType === 'collective-memory') {
                        $this->processCollectiveMemory($round, $questionKey, $questionData, $images, $answers);
                    } else {
                        $this->processDefaultRound($round, $questionKey, $questionData, $images, $answers);
                    }
                }
            }

            return redirect()->back()->with(['message' => 'Round data saved successfully!']);
        } catch (\Exception $e) {
            Log::error('Failed to save round data: ' . $e->getMessage());
            return redirect()->back()->with(['error' => 'Failed to save round data. Please try again.']);
        }
    }

    private function processDefaultRound($round, $questionKey, $questionData, $images, $answers): void
    {
        $questionText = is_array($questionData) ? ($questionData['text'] ?? null) : $questionData;
        $hasText = !empty($questionText);

        $file = $images[$questionKey] ?? null;
        $hasImage = $file instanceof UploadedFile && $file->isValid();

        if (!$hasText && !$hasImage) {
            return;
        }

        $question = Question::createOrUpdate($round->id, $questionText);

        $answerText = $answers[$questionKey] ?? null;
        if (!empty($answerText)) {
            Answer::createOrUpdate($question->id, $answerText);
        }

        // Save image if present
        if ($hasImage) {
            $filePath = $file->store('uploads/round-images', 'public');
            $question->update(['file_path' => $filePath]);
        }
    }

    private function processCollectiveMemory($round, $questionKey, $questionData, $images, $answers): void
    {
        $questionText = $questionData['text'] ?? null;
        $file = $images[$questionKey] ?? null;
        $hasText = !empty($questionText);
        $hasImage = $file instanceof UploadedFile && $file->isValid();

        if (!$hasText && !$hasImage) {
            return;
        }

        $question = Question::createOrUpdate($round->id, $questionText);

        if ($hasImage) {
            $filePath = $file->store('uploads/round-images', 'public');
            $question->update(['file_path' => $filePath]);
        }

        if (!empty($answers[$questionKey])) {
            foreach ($answers[$questionKey] as $keyword) {
                Answer::createOrUpdate($question->id, $keyword);
            }
        }
    }

    public function popupPlayerScreen()
    {

    }

    public function delete(Quiz $quiz): JsonResponse
    {
        $quiz->delete();
        return response()->json([
            'message' => 'Quiz successfully deleted.',
            'redirect' => route('quiz.index')
        ]);
    }
}
