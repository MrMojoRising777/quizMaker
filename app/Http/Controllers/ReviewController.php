<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Quiz $quiz, Request $request): RedirectResponse
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:255',
        ]);

        if (Review::where('user_id', auth()->id())->where('quiz_id', $request->quiz_id)->exists()) {
            return redirect()->back()->with('error', 'You have already reviewed this quiz.');
        }

        Review::create([
            'user_id' => auth()->id(),
            'quiz_id' => $quiz->id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
}
